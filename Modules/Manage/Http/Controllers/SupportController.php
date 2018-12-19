<?php

namespace Modules\Manage\Http\Controllers;

use GuzzleHttp\Client;
use Modules\Manage\Http\Requests\SupportRequest;
use Modules\Yasna\Services\YasnaController;

class SupportController extends YasnaController
{
    /**
     * The Main Folder of Views
     *
     * @var string
     */
    protected $view_folder = "manage::support";
    /**
     * The Request Object
     *
     * @var SupportRequest
     */
    protected $request;



    /**
     * Renders the single page of a ticket.
     *
     * @param SupportRequest $request
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function single(SupportRequest $request)
    {
        $ticket = $this->singleInfo($request);
        if (empty($ticket)) {
            return $this->abort(404);
        }

        $ticket_type = yasnaSupport()->getTicketTypeInfo($request->type);
        $timeline    = $this->singleTimeline($request);
        $page        = $this->singlePageInfo($ticket['title'], $ticket_type);

        return $this->view('single.main', compact('ticket', 'timeline', 'ticket_type', 'page'));
    }



    /**
     * Returns the page info for the single page
     *
     * @param string $ticket_title
     * @param array  $type
     *
     * @return array
     */
    public function singlePageInfo(string $ticket_title, array $type)
    {
        $manage_url = url('manage') . '/';
        return [
             [
                  str_after(
                       route('manage.support.list', ['type' => $type['slug']]),
                       $manage_url
                  ),
                  $this->module()->getTrans('support.tickets-of', ['title' => $type['title']]),
             ],
             [
                  str_after(
                       request()->url(),
                       $manage_url
                  ),
                  $ticket_title,
             ],
        ];
    }



    /**
     * Returns information of a ticket.
     *
     * @param SupportRequest $request
     *
     * @return array
     */
    protected function singleInfo(SupportRequest $request)
    {
        $id             = $request->hashid;
        $type           = $request->type;
        $response       = $this->clientObject()
                               ->get($type . '/tickets/' . $id)
        ;
        $response_array = json_decode($response->getBody()->__toString(), true);

        return ($response_array['results'][0] ?? []);
    }



    /**
     * Returns timeline of a ticket.
     *
     * @param SupportRequest $request
     *
     * @return array
     */
    protected function singleTimeline(SupportRequest $request)
    {
        $id             = $request->hashid;
        $type           = $request->type;
        $response       = $this->clientObject()
                               ->get($type . '/tickets/' . $id . '/timeline')
        ;
        $response_array = json_decode($response->getBody()->__toString(), true);

        return ($response_array['results'] ?? []);
    }



    /**
     * Renders a form to submit a new ticket.
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function new(SupportRequest $request)
    {
        $ticket_types = $this->getTicketTypes();
        $page         = $this->newPageInfo();
        return $this->view('single.new', compact('ticket_types', 'page'));
    }



    /**
     * Returns an array containing the page info of the new page.
     *
     * @return array
     */
    protected function newPageInfo()
    {
        return [
             [
                  str_after(
                       request()->url(),
                       url('manage') . '/'
                  ),
                  $this->module()->getTrans('support.new-ticket'),
             ],
        ];
    }



    /**
     * Returns an array of available tickets type in the remote site.
     *
     * @return array
     */
    protected function getTicketTypes()
    {
        return json_decode(
                  $this->clientObject()
                       ->get('types')
                       ->getBody()
                  , true) ?? [];
    }



    /**
     * Saves a ticket with the given data.
     *
     * @param SupportRequest $request
     *
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    public function save(SupportRequest $request)
    {
        $response = $this->clientObject()
                         ->post($request->ticket_type . '/tickets', [
                              'multipart' => array_merge(
                                   $this->generateSaveGeneralData($request),
                                   $this->generateSaveMultipartData($request)
                              ),
                         ])
        ;

        $response_array = json_decode($response->getBody()->__toString(), true);
        $id             = ($response_array['results'][0]['id'] ?? null);

        if ($id) {
            return $this->jsonAjaxSaveFeedback(1, [
                 'success_redirect' => route('manage.support.single', [
                      'hashid' => $id,
                      'type'   => $request->ticket_type,
                 ]),
            ]);
        }


        return $this->properFailureAjaxResponse($response_array);
    }



    /**
     * Returns an array of general data to be sent to save request.
     *
     * @param SupportRequest $request
     *
     * @return array
     */
    protected function generateSaveGeneralData(SupportRequest $request)
    {
        $data   = $request->only(['text', 'title']);
        $result = [];

        foreach ($data as $key => $value) {
            $result[] = [
                 'name'     => $key,
                 'contents' => $value,
            ];
        }

        return $result;
    }



    /**
     * Returns an array of attachments data to be sent to save request.
     *
     * @param SupportRequest $request
     *
     * @return array
     */
    protected function generateSaveMultipartData(SupportRequest $request)
    {
        $uploaded_files = ($request->attachments ?? []);
        $uploaded_files = array_filter($uploaded_files);
        $result         = [];

        foreach ($uploaded_files as $key => $uploaded_file) {
            $result[] = [
                 'name'     => "attachments_$key",
                 'filename' => $uploaded_file->getClientOriginalName(),
                 'contents' => file_get_contents($uploaded_file->getPathname()),
            ];
        }

        return $result;
    }



    /**
     * Returns a Client object to be used while calling API.
     *
     * @return Client
     */
    protected function clientObject()
    {
        return yasnaSupport()->authorizedClientObject('tickets/api/v1/');
    }



    /**
     * Returns a proper error response based on a failed AJAX response.
     *
     * @param array|null $response_array
     *
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    protected function properFailureAjaxResponse($response_array)
    {
        if (!$response_array) {
            return $this->jsonAjaxSaveFeedback(false);
        }

        if ($response_array['errorCode'] == 1002) {
            return $this->abort(
                 422,
                 true,
                 true,
                 array_only($response_array, 'errors')
            );
        }

        $user_message = ($response_array['userMessage'] ?? '');
        return $this->jsonAjaxSaveFeedback(false, [
             'danger_message' => $user_message,
        ]);
    }



    /**
     * Renders the list page of a ticket type.
     *
     * @param SupportRequest $request
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function list(SupportRequest $request)
    {
        $response = $this->listGetResponse($request);
        $results  = ($response['results'] ?? null);

        if (is_null($results)) {
            return $this->properFailureResponse($response);
        }

        $ticket_type = yasnaSupport()->getTicketTypeInfo($request->type);
        $page        = $this->listPageInfo($ticket_type);

        return $this->view('list.main', compact('response', 'ticket_type', 'page'));
    }



    /**
     * Returns an array version of the list response.
     *
     * @param SupportRequest $request
     *
     * @return array|null
     */
    public function listGetResponse(SupportRequest $request)
    {
        $response_obj = $this->clientObject()
                             ->get($request->type . '/tickets', [
                                  'query' => [
                                       'page' => $request->page,
                                  ],
                             ])
        ;

        return json_decode($response_obj->getBody(), true);
    }



    /**
     * Returns an array containing the page info of the list.
     *
     * @param array $ticket_type
     *
     * @return array
     */
    protected function listPageInfo(array $ticket_type)
    {
        return [
             [
                  str_after(
                       request()->url(),
                       url('manage') . '/'
                  ),
                  $this->module()->getTrans('support.tickets-of', ['title' => $ticket_type['title']]),
             ],
        ];
    }



    /**
     * Returns a proper error of a failed response.
     *
     * @param $response_array
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function properFailureResponse($response_array)
    {
        $error_code = ($response_array['errorCode'] ?? null);

        if ($error_code == '1005') {
            return $this->abort(404);
        }

        return $this->abort(403);
    }



    /**
     * Saves a reply for a ticket.
     *
     * @param SupportRequest $request
     *
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    public function reply(SupportRequest $request)
    {
        $uri      = $request->type . '/tickets/' . $request->hashid . '/replies';
        $response = $this->clientObject()
                         ->post($uri, [
                              'multipart' => array_merge(
                                   $this->generateSaveGeneralData($request),
                                   $this->generateSaveMultipartData($request)
                              ),
                         ])
        ;

        $response_array = json_decode($response->getBody()->__toString(), true);
        $id             = ($response_array['results'][0]['id'] ?? null);

        if ($id) {
            return $this->jsonAjaxSaveFeedback(1, [
                 'success_form_reset' => true,
                 'success_refresh'    => true,
            ]);
        }


        return $this->properFailureAjaxResponse($response_array);
    }
}
