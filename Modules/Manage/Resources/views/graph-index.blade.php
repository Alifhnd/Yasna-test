@extends('manage::layouts.template')

@section('content')

    <div class="row">
        <div class="col-lg-12 text-center">
            <h1>Sparkline Charts</h1>
        </div>
        <div class="col-sm-6">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel">
                            <div class="panel-body">
                                @include('manage::widgets.charts.bar.sparkline-bar',[
                                    'color'=> '#cfdbe2',
                                    'height'=> '30',
                                    'barWidth'=> '3',
                                    'barSpacing' => '2',
                                    'values' => '1,0,4,9,5,7,8,9,5,7,8,4,7'
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel">
                            <div class="panel-body">
                                @include('manage::widgets.charts.pie.sparkline-pie',[
                                    'color'=> '[ "#edf1f2", "#23b7e5"]',
                                    'height'=> '30',
                                    'values' => '20,80',
                                    'class'=> 'text-center'
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body">
                                @include('manage::widgets.charts.bar.sparkline-bar',[
                                    'color'=> '#23b7e5',
                                    'height'=> '50',
                                    'barWidth'=> '5',
                                    'barSpacing' => '2',
                                    'values' => '5,4,8,7,8,5,4,6,5,5,9,4,6,3,4,7,5,4,7',
                                    'class'=> 'text-center'
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
                <div class="panel">
                    <div class="panel-body">

                        @include('manage::widgets.charts.line.sparkline-line',[
                            'height'=> '80',
                            'width'=> '100%',
                            'lineWidth' => '2',
                            'lineColor' => '#7266ba',
                            'spotColor' => '#888',
                            'minColor' => "#7266ba",
                            'maxColor' => '#7266ba',
                            'fillColor'=> '',
                            'highlightLine' => 'transparent',
                            'spotRad' => '3',
                            'values' => '1,3,4,7,5,9,4,4,7,5,9,6,4',
                            'class'=> 'pv-lg'
                        ])
                    </div>
                </div>
            </div>
    </div>

    <div class="row">
        <div class="col-lg-12 text-center">
            <h1>Chart.js</h1>
        </div>
        <!-- //// CHart.js: Area \\\\ -->
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Chart.js_Area
                    </div>
                </div>
                <div class="panel-body">
                    @include('manage::widgets.charts.area.chartjs-area',[
                        'id'=> 'chartjs-area',
                        'labels'=> ['مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند', 'فروردین'],
                        'data' => [
                            [
                                'label' => 'گروه اول داده ها',
                                'backgroundColor' => 'rgba(114,102,186,0.2)',
                                'borderColor' => 'rgba(114,102,186,1)',
                                'pointBorderColor' => '#fff',
                                'data' => [10, 20, 30, 40, 50, 60, 70]
                            ],
                            [
                                'label' => 'گروه دوم داده ها',
                                'backgroundColor' => 'rgba(35,183,229,0.2)',
                                'borderColor' => 'rgba(35,183,229,1)',
                                'pointBorderColor' => '#fff',
                                'data' => [50, 100, 30, 10, 50, 80, 30]
                            ]
                        ],
                    ])
                </div>
            </div>
        </div>

        <!-- //// Chart.js: Bar \\\\ -->
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Chart.js_Bar
                    </div>
                </div>
                <div class="panel-body">
                    @include('manage::widgets.charts.bar.chartjs-bar',[
                        'id'=> 'chartjs-bar',
                        'labels'=> ['مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند', 'فروردین'],
                        'data' => [
                            [
                                'backgroundColor' => '#23b7e5',
                                'borderColor' => '#23b7e5',
                                'data' => [10, 20, 30, 40, 50, 60, 70]
                            ],
                            [
                                'backgroundColor' => '#5d9cec',
                                'borderColor' => '#5d9cec',
                                'data' => [50, 100, 30, 10, 50, 80, 30]
                            ]
                        ]
                    ])
                </div>
            </div>
        </div>

        <div class="row">
            <!-- //// Chart.js: Doughnut \\\\ -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Chart.js_Doughnut
                        </div>
                    </div>
                    <div class="panel-body">
                        @include('manage::widgets.charts.pie.chartjs-pie',[
							'id' => 'chart-doughnut-3',
							'type' => 'doughnut', // doughnut or pie
							'labels'=> ['مهر', 'آبان', 'آذر', 'دی', 'بهمن','مهر', 'آبان', 'آذر', 'دی', 'بهمن'],
							'data' => [
								[
									'backgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
									'hoverBackgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
									'data' => [45, 20, 100, 40, 50,45, 20, 100, 40, 50]
								]
							],
							"options" => [
								"legend" => [
									"display" => true ,
								] ,
							] ,

						])
                    </div>
                </div>
            </div>
        </div>

        <!-- //// Chart.js: Doughnut \\\\ -->
        <div class="col-lg-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Chart.js_Doughnut
                    </div>
                </div>
                <div class="panel-body">
                    @include('manage::widgets.charts.pie.chartjs-pie',[
                        'id' => 'chart-doughnut-2',
                        'type' => 'doughnut', // doughnut or pie
                        'labels'=> ['مهر', 'آبان', 'آذر', 'دی', 'بهمن','مهر', 'آبان', 'آذر', 'دی', 'بهمن'],
                        'data' => [
                            [
                                'backgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
                                'hoverBackgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
                                'data' => [45, 20, 100, 40, 50,45, 20, 100, 40, 50]
                            ]
                        ],
                        "options" => [
                            "legend" => [
                                "display" => true ,
                            ] ,
                        ] ,

                    ])
                </div>
            </div>
        </div>

        <!-- //// Chart.js: Doughnut \\\\ -->
        <div class="col-lg-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Chart.js_Doughnut
                    </div>
                </div>
                <div class="panel-body">
                    @include('manage::widgets.charts.pie.chartjs-pie',[
                        'id' => 'chart-doughnut',
                        'type' => 'doughnut', // doughnut or pie
                        'labels'=> ['مهر', 'آبان', 'آذر', 'دی', 'بهمن'],
                        'data' => [
                            [
                                'backgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
                                'hoverBackgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
                                'data' => [45, 20, 100, 40, 50]
                            ]
                        ],
                        "options" => [
                            "legend" => [
                                "display" => true ,
                            ] ,
                        ] ,

                    ])
                </div>
            </div>
        </div>

        <!-- //// Chart.js: Pie \\\\ -->
        <div class="col-lg-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Chart.js_Pie
                    </div>
                </div>
                <div class="panel-body">
                    @include('manage::widgets.charts.pie.chartjs-pie',[
                        'id' => 'chart-pie',
                        'type' => 'pie', // doughnut or pie
                        'labels'=> ['مهر', 'آبان', 'آذر', 'دی', 'بهمن'],
                        'data' => [
                            [
                                'backgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
                                'hoverBackgroundColor' => ['#f05050', '#7266ba','#fad732','#23b7e5', '#f532e5'],
                                'data' => [45, 20, 100, 40, 50]
                            ]
                        ]

                    ])
                </div>
            </div>
        </div>

        <!-- //// Chart.js: Polar \\\\ -->
        <div class="col-lg-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Chart.js_Polar
                    </div>
                </div>
                <div class="panel-body">
                    @include('manage::widgets.charts.pie.chartjs-polar',[
                        'id' => 'chart-polar',
                        'labels'=> ['پاییز', 'بهار', 'زمستان', 'تابستان'],
                        'data' => [
                            [
                                'backgroundColor' => ['#f532e5', '#7266ba', '#f532e5', '#7266ba'],
                                'data' => [11, 16, 7, 3],
                                'label'=> 'فصل ها' // for legend
                            ]
                        ]

                    ])
                </div>
            </div>
        </div>

        <!-- //// Chart.js: Radar \\\\ -->
        <div class="col-lg-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Chart.js_Radar
                    </div>
                </div>
                <div class="panel-body">
                    @include('manage::widgets.charts.pie.chartjs-radar',[
                        'id' => 'chart-radar',
                        'labels'=> ['خواب', 'غذاخوردن', 'ورزش', 'تفریح', 'کار', 'مطالعه', 'دیگر موارد'],
                        'data' => [
                            [
                                'label' => 'گروه اول',
                                'backgroundColor' => 'rgba(114,102,186,0.2)',
                                'borderColor' => 'rgba(114,102,186,1)',
                                'data' => [65, 59, 90, 81, 56, 55, 40]
                            ],
                            [
                                'label' => 'گروه دوم',
                                'backgroundColor' => 'rgba(35,183,229,0.2)',
                                'borderColor' => 'rgba(35,183,229,1)',
                                'data' => [28, 48, 40, 19, 96, 27, 100]
                            ]
                        ]

                    ])
                </div>
            </div>
        </div>


    </div>
    <hr>

    <div class="row">
        <div class="col-lg-12 text-center">
            <h1>Easy pie Chart</h1>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="panel">
                    <div class="panel-heading">Default</div>
                    <div class="panel-body text-center">
                        @include('manage::widgets.charts.pie.easypiechart',[
                            'id'=> 'pie1',
                            'percent' => '80',
                            'barColor' => '#27c24c'

                        ])
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="panel">
                    <div class="panel-heading">Slim</div>
                    <div class="panel-body text-center">
                        @include('manage::widgets.charts.pie.easypiechart',[
                            'id'=> 'pie2',
                            'percent' => '45',
                            'barColor' => '#7266ba',
                            'lineWidth' => '4'
                        ])
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="panel">
                    <div class="panel-heading">Track color</div>
                    <div class="panel-body text-center">
                        @include('manage::widgets.charts.pie.easypiechart',[
                            'id'=> 'pie3',
                            'percent' => '25',
                            'barColor' => '#f05050',
                            'scaleColor'=> '#232735',
                            'lineWidth' => '15'

                        ])
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="panel">
                    <div class="panel-heading">Scale color</div>
                    <div class="panel-body text-center">
                        @include('manage::widgets.charts.pie.easypiechart',[
                            'id'=> 'pie4',
                            'percent' => '60',
                            'barColor' => '#f05050',
                            'trackColor' => '#fad732',
                            'scaleColor'=> '#232735',
                            'lineWidth' => '15'

                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

{{-- @TODO: Panel collape still don't work --}}
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1>Color Pallet</h1>
            <div  class="panel panel-default">
                <div class="panel-heading">
                    <a href="#color-pallet" data-toggle="collapse" title="بستن پنل" class="pull-right collapse-btn">
                        <em class="fa fa-minus"></em>
                    </a>
                    <div class="panel-title">رنگ های پیش فرض استفاده شده در قالب</div>
                </div>
                <div id="color-pallet" class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-primary-light">bg-primary-light | #33b9ff</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-primary">bg-primary | #00a8ff</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-primary-dark">bg-primary-dark | #0086cc</div>
                            </div>
                        </div>
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-success-light">bg-success-light | #71db60</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-success">bg-success | #4cd137</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-success-dark">bg-success-dark | #3aad28</div>
                            </div>
                        </div>
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-info-light">bg-info-light | #51c6ea</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-info">bg-info | #23b7e5</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-info-dark">bg-info-dark | #1797be</div>
                            </div>
                        </div>
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-warning-light">bg-warning-light | #ffc973</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-warning">bg-warning | #ffb540</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-warning-dark">bg-warning-dark | #ffa10d</div>
                            </div>
                        </div>
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-danger-light">bg-danger-light | #ed7669</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-danger">bg-danger | #e74c3c</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-danger-dark">bg-danger-dark | #d62c1a</div>
                            </div>
                        </div>
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-inverse-light">bg-inverse-light | #46637f</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-inverse">bg-inverse | #34495e</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-inverse-dark">bg-inverse-dark | #22303d</div>
                            </div>
                        </div>
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-green-light">bg-green-light | #58ceb1</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-green">bg-green | #37bc9b</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-green-dark">bg-green-dark | #2b957a</div>
                            </div>
                        </div>
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-pink-light">bg-pink-light | #f763eb</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-pink">bg-pink | #f532e5</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-pink-dark">bg-pink-dark | #e90bd6</div>
                            </div>
                        </div>
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-purple-light">bg-purple-light | #a38ae1</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-purple">bg-purple | #8362D6</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-purple-dark">bg-purple-dark | #633acb</div>
                            </div>
                        </div>
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-yellow-light">bg-yellow-light | #fbe164</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-yellow">bg-yellow | #fad732</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-yellow-dark">bg-yellow-dark | #f3ca06</div>
                            </div>
                        </div>
                        <div class="table-grid">
                            <div class="col">
                                <div class="box-placeholder b0 bg-gray-darker">bg-gray-darker | #232735</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-gray-dark">bg-gray-dark | #3a3f51</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-gray">bg-gray | #dde6e9</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-gray-light">bg-gray-light | #e4eaec</div>
                            </div>
                            <div class="col">
                                <div class="box-placeholder b0 bg-gray-lighter">bg-gray-lighter | #edf1f2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
