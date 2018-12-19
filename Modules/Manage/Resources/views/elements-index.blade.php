@extends('manage::layouts.template')

@section('content')

    <h3>المنت ها
        <small>انواع المنت های موجود در قالب</small>
    </h3>

    <div class="row">
        <div class="col-md-6">
            <!-- Buttons -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">انواع دکمه های رنگی</h3>
                </div>
                <div class="panel-body">
                    @include('manage::forms.button',[
                        'shape' => 'default',
                        'label' => 'دکمه تست',
                        'class' => " "
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'primary',
                        'label' => 'دکمه تست',
                        'class' => " "
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'success',
                        'label' => 'دکمه تست',
                        'class' => " "
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'info',
                        'label' => 'دکمه تست',
                        'class' => " "
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'warning',
                        'label' => 'Warning',
                        'class' => " "
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'danger',
                        'label' => 'Danger',
                        'class' => " "
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'inverse',
                        'label' => 'Inverse',
                        'class' => " "
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'green',
                        'label' => 'Green',
                        'class' => " "
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'purple',
                        'label' => 'Purple',
                        'class' => " "
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'pink',
                        'label' => 'Pink',
                        'class' => " "
                    ])

                    <br>
                    <br>
                    <a href="#" class="btn btn-link">Button Link</a>
                    @include('manage::forms.button',[
                        'shape' => 'default',
                        'label' => 'button tag',
                        'class' => " "
                    ])
                    <a href="" class="btn btn-default">anchor tag</a>

                    <br>
                    <br>
                    @include('manage::forms.button',[
                        'shape' => 'default',
                        'label' => 'Default',
                        'class' => "btn-outline"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'primary',
                        'label' => 'Primary',
                        'class' => "btn-outline"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'success',
                        'label' => 'Success',
                        'class' => "btn-outline"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'info',
                        'label' => 'Info',
                        'class' => "btn-outline"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'warning',
                        'label' => 'Warning',
                        'class' => "btn-outline"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'danger',
                        'label' => 'Danger',
                        'class' => "btn-outline"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'inverse',
                        'label' => 'Inverse',
                        'class' => "btn-outline"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'green',
                        'label' => 'Green',
                        'class' => "btn-outline"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'purple',
                        'label' => 'Purple',
                        'class' => "btn-outline"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'pink',
                        'label' => 'Pink',
                        'class' => "btn-outline"
                    ])

                    <br>
                    <br>
                    @include('manage::forms.button',[
                        'shape' => 'primary',
                        'label' => 'btn-lg',
                        'class' => "btn-lg"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'primary',
                        'label' => 'btn-sm',
                        'class' => "btn-sm btn-outline"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'primary',
                        'label' => 'btn-xs',
                        'class' => "btn-xs"
                    ])

                    <br>
                    <br>

                    @include('manage::forms.button',[
                        'shape' => 'success',
                        'label' => 'btn-pill-left',
                        'class' => "btn-pill-left"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'info',
                        'label' => 'btn-oval',
                        'class' => "btn-oval"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'success',
                        'label' => 'btn-pill-right',
                        'class' => "btn-pill-right"
                    ])
                    @include('manage::forms.button',[
                        'shape' => 'danger',
                        'label' => 'btn-square ',
                        'class' => "btn-square "
                    ])

                </div>
            </div>
            <!-- Progress Bar -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Progress Bar</h3>
                </div>
                <div class="panel-body">
                    @include('manage::widgets.progress-bar',[
                        'bars'=>[
                            [
                                'value'=> 40,
                                'min' => 0, //optional
                                'max' => 100, //optional
                                'color' => 'success',
                            ]
                        ]
                    ])
                    @include('manage::widgets.progress-bar',[
                        'bars'=>[
                            [
                                'value'=> 20,
                                'min' => 0,
                                'max' => 100,
                                'color' => 'info',
                            ]
                        ]
                    ])
                    @include('manage::widgets.progress-bar',[
                        'size' =>'progress-sm', // optional: sm, xs
                        'bars'=>[
                            [
                                'value'=> 60,
                                'min' => 0,
                                'max' => 100,
                                'color' => 'warning',
                            ]
                        ]
                    ])
                    @include('manage::widgets.progress-bar',[
                        'size' =>'progress-xs',
                        'bars'=>[
                            [
                                'value'=> 80,
                                'min' => 0,
                                'max' => 100,
                                'color' => 'danger',
                            ]
                        ]
                    ])
                    @include('manage::widgets.progress-bar',[
                        'bars'=>[
                            [
                                'value'=> 40,
                                'min' => 0,
                                'max' => 100,
                                'color' => 'purple',
                                'type'=> 'progress-bar-striped' //optional
                            ]
                        ]
                    ])
                    @include('manage::widgets.progress-bar',[
                        'bars'=>[
                            [
                                'value'=> 36,
                                'color' => 'yellow',
                            ],
                            [
                                'value'=> 20,
                                'color' => 'warning',
                                'type' => 'progress-bar-striped'
                            ],
                            [
                                'value'=> 10,
                                'color' => 'danger',
                            ]
                        ]
                    ])

                </div>
            </div>


        </div>
        <div class="col-md-6">
            <!-- Notification and Alerts -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">اعلام وضعیت و اخطار</h3>
                </div>
                <div class="panel-body">
                    <p>اخطار و  اعلان های پیشفرض قالب</p>
                    <p>
                        <button type="button" data-notify="" data-message="پیام در اینجا نمایش داده می شود..." data-options="{&quot;status&quot;:&quot;danger&quot;}" class="btn btn-danger">Danger</button>
                        <button type="button" data-notify="" data-message="پیام در اینجا نمایش داده می شود..." data-options="{&quot;status&quot;:&quot;info&quot;}" class="btn btn-info">Info</button>
                        <button type="button" data-notify="" data-message="پیام در اینجا نمایش داده می شود..." data-options="{&quot;status&quot;:&quot;warning&quot;}" class="btn btn-warning">Warning</button>
                        <button type="button" data-notify="" data-message="پیام در اینجا نمایش داده می شود..." data-options="{&quot;status&quot;:&quot;success&quot;}" class="btn btn-success">Success</button>
                    </p>
                    <hr>
                    <p>مکان اخطار ها</p>
                    <p class="text-sm">bottom-center | bottom-left | bottom-right | top-center | top-right | top-left </p>
                    <p>
                        <button type="button" data-notify="" data-message="پیام در اینجا نمایش داده می شود..." data-options="{&quot;pos&quot;:&quot;bottom-center&quot;}" class="btn btn-default">Bottom Cener</button>
                        <button type="button" data-notify="" data-message="پیام در اینجا نمایش داده می شود..." data-options="{&quot;pos&quot;:&quot;top-left&quot;}" class="btn btn-default">Top Left</button>
                        <button type="button" data-notify="" data-message="پیام در اینجا نمایش داده می شود..." data-options="{&quot;pos&quot;:&quot;top-right&quot;}" class="btn btn-default">Top Right</button>
                        <button type="button" data-notify="" data-message="پیام در اینجا نمایش داده می شود..." data-options="{&quot;status&quot;:&quot;success&quot;, &quot;pos&quot;:&quot;bottom-right&quot;}" class="btn btn-default">Succes at Bottom Right</button>
                    </p>
                    <p>اخطار ساخت وطن</p>
                        <button class="btn btn-danger" onclick=" notif.show(' فایل شما زخیره شده است.', 'danger') ">اخطار!</button>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">اعلام وضعیت و اخطار</h3>
                </div>
                <div class="panel-body">
                    @include('manage::widgets.line-alerts',[
                        'type' => 'danger',
                        'notice'=> 'اخطار!', //optional
                        'massage' => ' شما می توانید این اعلان را ببندید. روی ضربدر کلیک کنید.',
                        'close' => true //optional
                    ])
                    @include('manage::widgets.line-alerts',[
                        'type' => 'success',
                        'notice'=> 'عالیه!',
                        'massage' => ' اینجا توضیحات مربوط به اعلان نمایش داده می شود.'
                    ])
                    @include('manage::widgets.line-alerts',[
                        'type' => 'info',
                        'notice'=> 'نکته!',
                        'massage' => ' اینجا توضیحات مربوط به اعلان نمایش داده می شود.'
                    ])
                    @include('manage::widgets.line-alerts',[
                        'type' => 'warning',
                        'notice'=> 'توجه!',
                        'massage' => ' اینجا توضیحات مربوط به اعلان نمایش داده می شود.'
                    ])

                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <!-- Page Tour and tutorial -->
        <div class="col-md-3">
            <div id="step1" class="panel panel-default"> {{--step 1 is for trip.js test--}}
                <div class="panel-heading">
                    <div class="panel-title">تور و آموزش</div>
                </div>
                <div class="panel-body">
                    <p>توضیحات مربوط به جاواسکریپت به طور کامل در کامنت</p>
                    <p>فایل js مربوط به این پلاگین را در پایین body  قرار دهید.</p>
                    <p>
                        <button id="start-tour" class="btn btn-primary mb-lg">شروع تور!</button>
                    </p>
                    <!-- Trip.js script -->
                    {{--
                    ---- Trip.js init
                    ---- indicate steps using class, id or attribute
                    ---- set the step in trip object using this format:
                    ---- { sel : $("#step1"), content : "توضیحات مرتبط با این قسمت", position : "e", header: 'مرحله اول'}
                    ---- position accepts e, w, n, s, screen-ne, screen-se, screen-sw, screen-nw, screen-center.
                    ---- onTripStart / onTripEnd : could be added to each step (or options for a default action) in order to set call back functions.
                    ---- onTripStart / onTripEnd of each step has priority to the default (in options).
                    ---- onStart / onEnd: You can set a callback function triggered when Trip.js starts / ends.
                    ---- Others: onTripStop, onTripPause, onTripResume, onTripChange, onTripClose
                    ---- More info: http://eragonj.github.io/Trip.js/documentations/configuration/
                    --}}
                    <script>
                        jQuery(function($){

                            let options = {
                                showNavigation : true,
                                prevLabel: '{{ trans('manage::template.prev') }}',
                                nextLabel: '{{ trans('manage::template.next') }}',
                                skipLabel: '{{ trans('manage::template.skip') }}',
                                finishLabel: '{{ trans('manage::template.finish') }}',
                                showCloseBox : true,
                                delay : -1,
                                animation: 'fadeIn',
                                tripTheme : "black",
                                showHeader: true,
                                onStart : function() {
                                    $('.trip-skip').show();
                                },
                                onEnd : function() {

                                }
                            };
                            let trip = new Trip([
                                { sel : $("#step1"), content : "توضیحات مرتبط با این قسمت", position : "s", header: 'مرحله اول',
                                    onTripStart: function(tripIndex) {
                                        console.log('onTripStart : ', tripIndex);
                                    },
                                    onTripEnd: function(tripIndex) {
                                        console.log('onTripEnd : ', tripIndex);
                                    }
                                },
                                { sel : $(".step2"), content : "توضیحات مرتبط با این قسمت",  position : "n" , header: 'مرحله دوم' },
                                { sel : $("#step2"), content : "توضیحات مرتبط با این قسمت", position : "n" , header: 'مرحله سوم' },
                                { sel : $("#step4"), content : "توضیحات مرتبط با این قسمت",  position : "e" , header: 'مرحله چهارم',
                                    onTripStart: function() {
                                        $('.trip-skip').hide();
                                    }
                                }
                            ], options);

                            //Trip start and customization
                            //trip.start();
                            $("#start-tour").on("click", function() {
                                trip.start();
                            });
                        }); //End Of siaf!
                    </script>
                    <!-- End trip.js -->
                </div>
            </div>
            {{-- @TODO: Panel collape still don't work --}}
            <div  class="panel panel-default step2"> {{--step 2 is for trip.js test--}}
                <div class="panel-heading">پنل جمع شونده
                    <a href="#panel1" data-toggle="collapse" title="Collapse Panel" class="pull-right collapse-btn" aria-expanded="false">
                        <em class="fa fa-plus"></em>
                    </a>
                </div>
                <div id="panel1" class="panel-wrapper collapse">
                    <div class="panel-body">
                        <p>Panel can be collapsed clicking on the chevron up/down icon on the top right corner</p>
                    </div>
                    <div class="panel-footer">Panel Footer</div>
                </div>
            </div>

        </div>

        <!-- Accordions -->
        <div class="col-md-9">
            <div class="panel panel-default panel-info">
                <div class="panel-heading">پنل های آکاردئونی</div>
                <div class="panel-body">
                    <div id="accordion" role="tablist" aria-multiselectable="true" class="panel-group">
                        <div id="step3" class="panel panel-default"> {{--step 3 is for trip.js test--}}
                            <div id="headingOne" role="tab" class="panel-heading">
                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">          گروه اول        </a>
                                </h4>
                            </div>
                            {{-- panel accordion could be open on page load by adding "in" class to ".tabpanel" div --}}
                            <div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div id="headingTwo" role="tab" class="panel-heading">
                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="collapsed">          گروه دوم        </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" role="tabpanel" aria-labelledby="headingTwo" class="panel-collapse collapse">
                                <div class="panel-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                    moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur
                                    butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven&apos;t heard of them accusamus labore sustainable VHS.</div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div id="headingThree" role="tab" class="panel-heading">
                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="collapsed">          گروه سوم        </a>
                                </h4>
                            </div>
                            <div id="collapseThree" role="tabpanel" aria-labelledby="headingThree" class="panel-collapse collapse">
                                <div class="panel-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                    moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur
                                    butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven&apos;t heard of them accusamus labore sustainable VHS.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- New form El -->
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    المنت‌های فرم
                </div>
                <div class="panel-body">

                    <div class="row">
                        <!-- vue-color picker -->
                        <div class="col-md-4">
                            <div class="form-horizontal">

                                {!!
								   widget('colorpicker')
								   ->id('app2')
								   ->value('#40E0B3')
								   ->name('negar')
								   ->title('tooltip')
								   ->inForm()
								   ->label('Color Picker')
								!!}

                            </div>
                        </div>
                        <!-- !END vue-color picker -->

                        <!-- icon picker -->
                        <div class="col-md-4">
                            {!!
                            widget('icon-picker')
                            ->inForm()
                            ->label("Icon Picker")
                            !!}

                        </div>
                        <!-- !END icon picker -->

                        <!-- Slider -->
                        <div class="col-md-4">
                            {!!
								widget('slider')
								->min(5)
								->max(50)
								->value(20)
								->inForm()
								->label('Slider')
								->step(5)
							 !!}
                        </div>
                        <!-- !END Slider -->
                    </div>

                    <!-- New DatePicker -->
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-horizontal">
                                {!!
								   widget('PersianDatePicker')
								   ->id('pdatepickerTest')
								   ->class('pdatepickerClass')
								   ->label('Range DatePicker')
								   ->name('testname')
								   ->inForm()
								   ->canNotScroll()
								   ->inRange()
								   //->valueFrom('1397-8-4')
								   //->valueTo('1397-8-15')
								   ->initialValueType('persian')
								   ->placeholderFrom('tr:manage::forms.general.from')
								   ->placeholderTo('tr:manage::forms.general.till')
								!!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            {!!
                               widget('PersianDatePicker')
                               ->id('pdatepickerTest2')
                               ->class('pdatepickerClass2')
                               ->label('Single DatePicker')
                               ->name('testname')
                               ->inForm()
                               ->canScroll()
                               ->value('2018-05-12 05:14:16')
                               ->min('2018-05-05 05:14:16')
                               ->max('2018-05-25 05:14:16')
                            !!}
                        </div>
                        <div class="col-sm-4">
                            {!!
                               widget('PersianDatePicker')
                               ->id('pdatepickerTest3')
                               ->class('pdatepickerClass3')
                               ->label('Time Picker')
                               ->name('testname')
                               ->inForm()
                               ->value('2018-04-15 05:14:16')
                               ->canNotScroll()
                               ->onlyTimePicker()
                            !!}
                        </div>
                    </div>
                    <!-- !END New DatePicker -->

                    <div class="row">
                        <!-- Selectize -->
                        <div class="col-sm-4">
                            {!!
                                widget('selectize')
                                ->id('bla')
                                ->inForm()
                                ->label('Selectize')
                                ->options([
                                    [
                                        "name" => "Name 1" ,
                                        "value" => "value1" ,
                                    ],
                                    [
                                        "name" => "Name 2" ,
                                        "value" => "value2" ,
                                        "background" => "#f532e5" ,

                                    ],
                                    [
                                        "name" => "Name 3" ,
                                        "value" => "value3" ,
                                        "background" => "#0055ff" ,
                                    ],
                                ])
                                ->valueField('value')
                                ->captionField('name')
                                ->customBackground('background')
                             !!}
                        </div>
                        <!-- End! Selectize -->
                    </div>
                </div>
            </div>
        </div>
        <!-- !END New form El -->

    </div>

    <div  id="step4" class="row">
        <div class="col-md-4">
            @include('manage::widgets.widget-cards',[
                'type' => 'full', //full or half
                'color' => 'pink',
                'title' => '100%',
                'text' => 'VOLUME'
            ])
            @include('manage::widgets.widget-cards',[
                'type' => 'full',
                'color' => 'purple',
                'title' => '10K',
                'text' => 'VISITORS'
            ])

        </div>
        <div class="col-md-4">
            @include('manage::widgets.widget-cards',[
                'type' => 'half',
                'color' => 'danger',
                'icon' => 'music',
                'title' => '100%',
                'text' => 'VOLUME'
            ])
            @include('manage::widgets.widget-cards',[
                'type' => 'half',
                'color' => 'inverse',
                'icon' => 'code-fork',
                'title' => '150',
                'text' => 'FORKS'
            ])

        </div>
        <div class="col-md-4">
            @include('manage::widgets.widget-cards',[
                'type' => 'full', //full or half
                'color' => 'green',
                'title' => '100%',
                'text' => 'VOLUME'
            ])
            @include('manage::widgets.widget-cards',[
                'type' => 'full',
                'color' => 'primary',
                'title' => '10K',
                'text' => 'VISITORS'
            ])
        </div>
    </div>

    <h4 class="page-header">Whirl Loaders
        <small class="text-muted">با اضافه کردن کلاس های مربوطه می توان این لودر ها را حتی در پنل نیز استفاده کرد.</small>
    </h4>
    <!-- START row-->
    <div class="row">
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">standard</div>
                <div class="panel-body whirl standard">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">traditional</div>
                <div class="panel-body whirl traditional">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">double-up</div>
                <div class="panel-body whirl double-up">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">duo</div>
                <div class="panel-body whirl duo">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">blade</div>
                <div class="panel-body whirl blade">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">ringed</div>
                <div class="panel-body whirl ringed">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">helicopter</div>
                <div class="panel-body whirl helicopter">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">line</div>
                <div class="panel-body whirl line">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">line grow</div>
                <div class="panel-body whirl line grow">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">line back-and-forth</div>
                <div class="panel-body whirl line back-and-forth">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">line back-and-forth grow</div>
                <div class="panel-body whirl line back-and-forth grow">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">sphere</div>
                <div class="panel-body whirl sphere">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">sphere vertical</div>
                <div class="panel-body whirl sphere vertical">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">bar</div>
                <div class="panel-body whirl bar">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">bar follow</div>
                <div class="panel-body whirl bar follow">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">shadow</div>
                <div class="panel-body whirl shadow">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">shadow oval</div>
                <div class="panel-body whirl shadow oval">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">shadow oval right</div>
                <div class="panel-body whirl shadow oval right">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
        <div class="col-md-3">
            <!-- START panel-->
            <div class="panel panel-default">
                <div class="panel-heading">no-overlay</div>
                <div class="panel-body whirl no-overlay">
                    <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                </div>
            </div>
            <!-- END panel-->
        </div>
    </div>

    <h4 class="page-header">Nestable
        <small class="text-muted">لیست هایی با قابلیت جابجایی و اولویت بندی از طریق drag and drop</small>
    </h4>

    <div class="container-fluid">
        <p>فایل js مربوط به این پلاگین را در پایین body  قرار دهید.</p>
        <div class="js-nestable-action">
            <a data-action="expand-all" class="btn btn-default btn-sm mr-sm">باز کردن همه</a>
            <a data-action="collapse-all" class="btn btn-default btn-sm">بستن همه</a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="nestable" class="dd">
                    <ol class="dd-list">
                        <li data-id="1" class="dd-item">
                            <div class="dd-handle">Item 1</div>
                        </li>
                        <li data-id="2" class="dd-item">
                            <div class="dd-handle">Item 2</div>
                           <ol class="dd-list">
                                <li data-id="3" class="dd-item">
                                    <div class="dd-handle">Item 3</div>
                                </li>
                                <li data-id="4" class="dd-item">
                                    <div class="dd-handle">Item 4</div>
                                </li>
                                <li data-id="5" class="dd-item">
                                    <div class="dd-handle">Item 5</div>
                                    <ol class="dd-list">
                                        <li data-id="6" class="dd-item">
                                            <div class="dd-handle">Item 6</div>
                                        </li>
                                        <li data-id="7" class="dd-item">
                                            <div class="dd-handle">Item 7</div>
                                        </li>
                                        <li data-id="8" class="dd-item">
                                            <div class="dd-handle">Item 8</div>
                                        </li>
                                    </ol>
                                </li>
                                <li data-id="9" class="dd-item">
                                    <div class="dd-handle">Item 9</div>
                                </li>
                                <li data-id="10" class="dd-item">
                                    <div class="dd-handle">Item 10</div>
                                </li>
                            </ol>
                        </li>
                        <li data-id="11" class="dd-item">
                            <div class="dd-handle">Item 11</div>
                        </li>
                        <li data-id="12" class="dd-item">
                            <div class="dd-handle">Item 12</div>
                        </li>
                    </ol>
                </div>
                <textarea id="nestable-output" class="form-control"></textarea>
            </div>
        </div>
    </div>

    <script>
        //Nestable config and init
        $(function(){

            var updateOutput = function(e)
            {
                var list   = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            // activate Nestable for list 1
            $('#nestable').nestable({
                group: 1
            })
                .on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));

            $('.js-nestable-action').on('click', function(e)
            {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });
        });
    </script>

@endsection
