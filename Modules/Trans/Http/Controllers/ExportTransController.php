<?php

namespace Modules\Trans\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Modules\Trans\services\TransDiff\TransDiff;
use Modules\Yasna\Http\Requests\SimpleYasnaRequest;
use Modules\Yasna\Services\YasnaController;

class ExportTransController extends YasnaController
{
    protected $base_model  = 'Trans';
    protected $view_folder = 'trans::downstream';



    /**
     * Show modal for export trans file
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function exportModal()
    {
        $locales      = [];
        $modules      = [];
        $modules_name = implode(',', module()->list()) . ',overall';

        $locales_name = implode(',', setting('site_locales')->gain());

        foreach (module()->list() as $module) {
            array_push($modules, ['caption' => module($module)->getTitle(), 'value' => $module]);
        }
        array_push($modules, ['caption' => trans('trans::downstream.excel.overall'), 'value' => 'overall']);

        foreach (setting('site_locales')->gain() as $locale) {
            array_push($locales, ['caption' => trans('manage::forms.lang.' . $locale), 'value' => $locale]);
        }

        return view('trans::excel.export', compact('locales', 'modules', 'modules_name', 'locales_name'));
    }



    /**
     * @param SimpleYasnaRequest $request
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(SimpleYasnaRequest $request)
    {
        $modules = explode(',', $request->modules);
        $locales = explode(',', $request->locales);
        $data    = [
             'modules' => $modules,
             'locales' => $locales,
        ];

        session()->put('export-trans', $data);

        return $this->jsonAjaxSaveFeedback(true, [
             'success_redirect' => route("manage.trans.download"),
        ]);
    }



    /**
     * download an excel file.
     */
    public function download()
    {
        $data    = session()->pull('export-trans');
        $modules = $data['modules'];
        $locales = $data['locales'];
        $data    = $this->getExcelData($locales, $modules);

        $file_name = 'yasna_trans__' . date("Y_m_d__h_i");
        Excel::create($file_name, function ($excel) use ($data, $locales) {
            foreach ($data as $module_name => $rows) {
                $excel->sheet($module_name, function ($sheet) use ($locales, $rows) {
                    $sheet->loadView("trans::excel.excel")->with(['header' => $locales, 'rows' => $rows]);
                    $sheet->setWidth([
                         'A' => 50,
                         'B' => 30,
                    ]);
                });
            }
        })->download('xls')
        ;

    }



    /**
     * return modules with all unique keys
     *
     * @param array $locales
     * @param array $modules
     *
     * @return array
     */
    public function getExcelData($locales, $modules)
    {
        $data    = [];
        $trans   = new TransDiff();
        $modules = $trans->getModulesAllKeysTogether($modules);


        foreach ($modules as $module_name => $trans) {
            $rows = [];
            foreach ($trans as $key) {
                $row = [];
                array_push($row, $key);
                foreach ($locales as $locale) {
                    array_push($row, $this->trans($key, $locale));
                }
                array_push($rows, $row);
            }
            $data[$module_name] = $rows;
        }
        config(['app.fallback_locale' => 'en']);
        return $data;
    }



    /**
     * translate the trans key without default locale
     *
     * @param string $key
     * @param string $lang
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function trans($key, $lang)
    {
        config(['app.fallback_locale' => $lang]);
        $trans = trans($key, [], $lang);

        if ($trans != $key) {
            return $trans;
        }
        return '';
    }


}
