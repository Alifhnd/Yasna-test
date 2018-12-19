<?php namespace Modules\Manage\Services;

class Helper
{
    protected $void_link = 'javascript:void(0)';



    /**
     * Separates js commands from href links
     *
     * @param      $link
     * @param bool $model
     *
     * @return array [href, js]
     */
    public function parseLink($link, $model = null)
    {
        $href   = $link;
        $js     = null;
        $target = "_self";
        $set    = false;

        /*-----------------------------------------------
        | Parse Model things ...
        */
        if (isset($model)) {
            if (isset($model->id)) {
                $link = str_replace('-id-', $model->id, $link);
            }
            if (isset($model->hash_id)) {
                $link = str_replace('-hash_id-', $model->hash_id, $link);
                $link = str_replace('-hashid-', $model->hash_id, $link);
            }
        }

        /*-----------------------------------------------
        | Parse Modal Openers ...
        */
        if (str_contains($link, 'modal:')) {
            $link       = str_replace('modal:', null, $link);
            $modal_link = url(str_before($link, ':'));
            $modal_size = str_after($link, ':');
            if (!$modal_size or not_in_array($modal_size, ['lg', 'sm'])) {
                $modal_size = 'lg';
            }

            $js   = "masterModal('$modal_link' , '$modal_size')";
            $href = $this->void_link;
            $set  = true;
            $link = null;
        }


        /*-----------------------------------------------
        | Parse url() ...
        */
        if (str_contains($link, 'urlN:')) {
            $target = "_blank";
            $link = str_replace('urlN:', 'url:', $link);
        }
        if (str_contains($link, 'url:')) {
            $href = url(str_after($link, 'url:'));
            $set  = true;
        }


        /*-----------------------------------------------
        | Parse JS commands ...
        */
        if (str_contains($link, '(')) {
            $js   = $link;
            $href = $this->void_link;
            $set  = true;
        }

        /*-----------------------------------------------
        | Special 'NO' Provision ...
        */
        if ($link == 'NO') {
            $js   = null;
            $href = $this->void_link;
            $set  = false;
        }


        /*-----------------------------------------------
        | Return ...
        */
        return [
             'href'   => $href,
             'js'     => $js,
             'target' => $target,
             'set'    => $set,
        ];
    }
}
