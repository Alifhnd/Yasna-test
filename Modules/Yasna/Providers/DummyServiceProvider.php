<?php namespace Modules\Yasna\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class DummyServiceProvider extends ServiceProvider
{
    protected static $persian_text     = "لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی است. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می‌طلبد تا با نرم‌افزارها شناخت بیشتری را برای طراحان رایانه‌ای علی‌الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می‌توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.";
    protected static $english_text     = 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
    protected static $persian_titles   = [
         'اعتراض کسبه بازار رضا به حضور ماموران برای جمع آوری نقره‌های قاچاق',
         'چهل روز بعد از حادثه پلاسکو، مردم و مسئولان چه می‌گویند',
         'بیشتر بازیکنان این تیم پناهندگان تبتی هستند',
         'فرمان مهاجرتی ترامپ سفر شهروندان هفت کشور به آمریکا را به طور موقت محدود کرده است',
         'دادگاه ادعا این مردان را رد کرد',
         'این حمله در شب سال نو روی داد',
         'بال پهپادها به فضای مبارزه با فساد هم باز شد',
         'دموکرات‌ها در آمریکا: وزیر دادگستری از مقامش استعفا کند',
         'درگیری‌ دو گروه کرد در شمال غرب عراق',
         'فرماندهان پلیس کابل و چند شهر دیگر عوض شدند',
         'جف بزوس حالا در اندیشه تحویل کالا در ماه است',
         'پشتیبانی از لاک اسکرین به نسخه اندروید دستیار کورتانا اضافه شد',
         'دسترسی به دستیار گوگل در پیام رسان Allo تسهیل شد',
         'هفت سنگ؛ خیزش شیاطین',
         'تاریخ عرضه نسخه پی سی و مشخصات سخت افزاری مورد نیاز',
         'روزیاتو: ۹ مورد از سنگین وزن ترین رکوردهای جهانی گینس که شما را متعجب خواهند کرد',
         'دادگاه تاریخی مدیر عامل سامسونگ نوزدهم اسفند ماه برگزار می گردد',
         'آمازون در حال توسعه یک دوربین امنیتی خانگی است',
         'توییتر و برداشتن گام های تازه برای محدود کردن فعالیت اکانت هایی با محتوای آزاردهنده',
         'سامسونگ و تاسیس دفتری تازه برای کنترل کیفیت هرچه بیشتر محصولات',
         'دستگاهی که برای جابز حکم سرگرمی را داشت، به لیست از رده خارج شده های اپل پیوست',
         'گوگل برنامه ای برای تولید موبایل پیکسل ارزان قیمت ندارد',
         'کمپانی لنوو تصمیم به حفظ نام و برند موتورولا گرفت',
         'سامسونگ و ترغیب تولیدکنندگان برای بهره گیری از چیپست اگزینوس در هدست های واقعیت مجازی',
         'ساختمان مرکزی میونیک ری، در مونیخ',
         'بازوی ارائه خدمات اولیه بیمه فعالیت می‌نماید',
         'با  حضور سرپرست اداره کل آموزش و پرورش و مدیران بیمه',
         'برای خداوند هیچ کاری غیر ممکن نیست',
         'در تمام زندگی به او اعتماد کن و در حضورش بمان و امیدت به او باشد',
         'صبح بخیر و شادی',
         'اجلاس مدیریت پسماند و حفظ محیط زیست ایران و آلمان',
         'حضور شرکت سهامی بیمه',
         'سقوط پل در تهران',
         'برگزاری دوره آموزشی سیستم رسیدگی به شکایات مشتریان در شرکت بیمه حافظ',
         'ناتوانی صنعت بیمه در پوشش اقتصاد ایران',
         'سفر مدیرعامل بیمه‌ کوثر به استان قزوین',
         'گزارشی از پرونده بیمه توسعه از زبان مدیریت امور حقوقی شرکت بیمه ایران',
         'دفاتر اداری مت‌لایف، در برج مت‌لایف و ساختمان شمالی، نیویورک',
         'اظهارات تند و تیز وزیر اقتصاد درباره فساد اقتصادی',
         'پرودنشال پی‌ال‌سی',
         'کانال گروه اخبار بیمه گران',
         'انفجار در خط تغذیه گاز نیروگاه برق علی‌آباد کتول',
         'رشد سریعتر صنعت بیمه نسبت به کل اقتصاد',
         'سخنرانی دکتر طباطبایی ',
         'درس گفتارهایی درباره افلاطون',
         'سیر تاریخی تحول فهم قرآن',
         'سخنرانی هاشم آقاجری، کریم سلیمانی، محمد مالجو',
         'حق انتقاد در حكومت اسلامي',
         'سخنرانی مصطفی ملکیان',
         'سلامت روان یا انسان خودشکوفا',
         'سخنرانی استاد علی شریعتی ',
         'ویدیوی بازی فوتبال فیلسوفان بزرگ جهان',
         'صحبت های قابل تامل  محمد رضا',
         'شیوه‌های تغییر رفتار در بزرگسالی',
         'سلسله سخنرانی های دکتر فرنودی',
         'این سرزمین مال کیست؛ اسرائیلیان یا فلسطینی‌ها؟',
         'منصور فرهنگ ‌استاد علوم سیاسی ',
         'فلسفه در یونان و روم باستان',
    ];
    protected static $persian_names    = [
         " فاطمه خانم",
         " ابوطالب",
         " افسانه",
         " الاهه",
         " راضیه",
         " سمانه",
         " علیرضا",
         " فاطمه",
         " فرزانه",
         " فرهاد",
         " معصومه",
         " نسترن",
         " آرزو",
         " آرمان",
         " آزاده ",
         " ارشاد",
         " اسکندر",
         " اسما",
         " افسانه",
         " اکرم",
         " الهام",
         " الهه",
         " الیاس ",
         " امیر",
         " ایاد",
         " برکت اله",
         " بلال",
         " بهروز",
         " بی بی فاطمه سادات ",
         " پیمان",
         " تهمینه",
         " جواد",
         " حسین",
         " حمید",
         " حنانه",
         " دانیال",
         " داود",
         " رسول",
         " رویا",
         " ریحانه",
         " زهرا",
         " ساجده",
         " سارا",
         " سامان",
         " سجاد",
         " سعید",
         " سمیه",
         " سهراب",
         " سودا",
         " سوده",
         " سوگند",
         " سید محمد رضا",
         " سیدرضا",
         " سیدسینا",
         " سیده معصومه",
         " سیمین",
         " شهربانو",
         " شهناز",
         " صابر",
         " عارفه",
         " عاطفه",
         " عبدالله",
         " عشرت",
         " علیرضا",
         " عمید",
         " غلامرضا",
         " فائزه ",
         " فاطمه",
         " فرانک",
         " فرزانه",
         " فرشته",
         " کامران",
         " کوروش",
         " مائده",
         " محسن",
         " محمد",
         " محمد حسین ",
         " محمد مهدی ",
         " محمدباقر",
         " محمدحسین",
         " محمدرضا",
         " محیا",
         " مرضیه",
         " مروارید",
         " مریم",
         " مریم السادات",
         " مژگان",
         " مصطفی",
         " معصومه",
         " ملیحه",
         " منیره",
         " مهدی",
         " مهراد",
         " مهسا",
         " میترا",
         " مینا",
         " نازیلا",
         " ناهید",
         " نرگس",
         " نسیم",
         " نوشین",
         " وحید",
         " یاسر",
         " یاسین",
         " .مبینا ",
         " /فاطمه",
         " آتنا",
         " آدرین",
         " آذر",
         " آذین",
         " آذین السادات",
         " آرزو",
         " آرزوالسادات",
         " آرش",
         " آرمان",
         " آرین",
         " آزاد",
         " آزاده",
         " آزیتا",
         " آلما",
         " آمنه",
         " آنیتا",
         " آی تک",
         " آیدا",
         " آیسان",
         " ائل شن",
         " ابراهیم",
         " ابوالفضل",
         " ابوالقاسم",
         " ابوذر",
         " ابوطالب",
         " احسان",
         " احمد",
         " احیا",
         " ارزو",
         " ارمان",
         " اسدالله",
         " اسماعیل",
         " اسمعیل",
         " اشکان",
         " اصغر",
         " اعظم",
         " اعظم صبا",
         " افسانه",
         " افشین",
         " اکبر",
         " اکرم ",
         " السادات",
         " الناز",
         " الهام",
         " الهامه",
         " الهه",
         " الیاس",
         " امید",
         " امیر",
         " امیر حسین",
         " امیر عرشیا",
         " امیر محمد",
         " امیرحسین",
         " امیرمحمد",
         " امیرمهدی",
         " امین",
         " امین الله",
         " امینه",
         " امینه سادات",
         " انسیه",
         " انیس",
         " انیسه",
         " ایمان",
         " ایوب",
         " بابک",
         " بایرامعلی",
         " بتول",
         " بنت الهدی",
         " بنفشه سادات",
         " بهاره",
         " بهروز ",
         " بهزاد",
         " بهناز",
         " بهنام",
         " بهنوش",
         " بهیه",
         " بی بی سمیرا ",
         " بی بی سمیه",
         " بیتا",
         " بیژن",
         " پانته آ",
         " پرستو",
         " پروین",
         " پری ناز",
         " پریا",
         " پریچهر",
         " پریسا",
         " پگاه",
         " پوران",
         " پوریا",
         " پونه",
         " پیمان",
         " تکتم",
         " تینا",
         " ثمر",
         " ثمیلا",
         " ثمینه",
         " جعفر",
         " جمال",
         " جمیله",
         " جواد",
         " چکاوک",
         " حامد",
         " حانیه",
         " حبیب",
         " حبیب الله",
         " حجت",
         " حدیث",
         " حدیثه",
         " حسن",
         " حسن علی",
         " حسین",
         " حشمت الله",
         " حکیمه",
         " حمید",
         " حمیدرضا",
         " حنانه",
         " حوری",
         " خدیجه",
         " خوب یار",
         " خیرالنسا",
         " داود",
         " دنیا",
         " ذبیح الله",
         " راحله",
         " راضیه",
         " رامتین",
         " رامونا",
         " رامین",
         " ربابه",
         " رجا",
         " رحیم",
         " رز",
         " رزیتا",
         " رسول ",
         " رضا",
         " رضیه",
         " رعنا",
         " رقیه",
         " رقیه بیگم",
         " روح الله",
         " روح اله",
         " روشنک",
         " رویا",
         " ریحانه",
         " زرین",
         " زکیه",
         " زکیه سادات",
         " زهرا",
         " زهرا سادات",
         " زهراالسادات",
         " زهراسادات",
         " زهره",
         " زیبا",
         " زینب",
         " زینت ",
         " ژاله",
         " ساحل",
         " سارا",
         " ساسان",
         " ساغر",
         " سالار",
         " سامرند",
         " سامره",
         " ساناز",
         " سبا",
         " سبحان",
         " سپهر",
         " سپیده",
         " ستاره",
         " سجاد",
         " سحر",
         " سحرناز",
         " سرور",
         " سروین",
         " سعید",
         " سعیده",
         " سکینه",
         " سلطان علی ",
         " سما",
         " سمانه",
         " سمانه سادات",
         " سمیرا",
         " سمیه",
         " سنا",
         " سهیلا",
         " سوتیام",
         " سودا",
         " سودابه",
         " سوده",
         " سوری",
         " سوگند",
         " سیامک",
         " سیاوش",
         " سید ابراهیم ",
         " سید احمد",
         " سید امیراسعد",
         " سید امیرحسین",
         " سید امین",
         " سید ایمان",
         " سید بهزاد",
         " سید حسین",
         " سید رزاق",
         " سید رضا ",
         " سید طاهر",
         " سید علی",
         " سید قاسم",
         " سید کلثوم",
         " سید مجید",
         " سید محمد",
         " سید محمد اسماعیل",
         " سید محمد امین ",
         " سید محمد حسین",
         " سید مهدی",
         " سید مهیار ",
         " سیدالیاس",
         " سیدحمید ",
         " سیدحمید رضا ",
         " سیدقاسم",
         " سیدمجتبی",
         " سیدمجید",
         " سیدمحمد",
         " سیدمحمدحسن",
         " سیدمحمدمهدی",
         " سیدمصطفی",
         " سیدمهدی",
         " سیدمهران",
         " سیدمیلاد",
         " سیده اشرف",
         " سیده تارا",
         " سیده زهرا",
         " سیده زینب",
         " سیده سمانه",
         " سیده شهره ",
         " سیده صدیقه",
         " سیده طیبه",
         " سیده غنچه",
         " سیده فاطمه",
         " سیده فاطمه زهرا",
         " سیده فرزانه",
         " سیده لیلا",
         " سیده مائده",
         " سیده مطهره",
         " سیده معصومه",
         " سیده مهدیه",
         " سیده نرگس",
         " سیده نسرین",
         " سیده یگانه",
         " سیدهاشم ",
         " سیدیحیی",
         " سیما",
         " سینا",
         " شاهدخت",
         " شایان",
         " شبنم",
         " شراره",
         " شرمین",
         " شقایق",
         " شکوفا",
         " شکوفه",
         " شهاب",
         " شهرام",
         " شهربانو",
         " شهرزاد",
         " شهره",
         " شهریار",
         " شهلا",
         " شهناز",
         " شیرین",
         " شیما ",
         " شیوا",
         " صادق",
         " صبا",
         " صدریه",
         " صدف",
         " صدیقه",
         " صفورا",
         " صلاح الدین",
         " صمد",
         " طاهر",
         " طاهره",
         " طهورا",
         " طیبه",
         " ظهراب",
         " عادله",
         " عاطفه",
         " عباس",
         " عباسعلی",
         " عبدالجواد",
         " عبدالله",
         " عبدالمجید",
         " عذرا",
         " عرفان",
         " عسگر",
         " عصمت",
         " عطیه",
         " عفت",
         " علی",
         " علی اکبر",
         " علی رضا ",
         " علیرضا",
         " عیسی",
         " غزاله",
         " فائزه",
         " فاطمه",
         " فاطمه بیگم ",
         " فاطمه زهرا",
         " فایزه",
         " فتانه",
         " فخرالسادات",
         " فخری",
         " فربد",
         " فرخنده",
         " فرزانه",
         " فرشاد",
         " فرشته",
         " فرشید",
         " فرناز",
         " فروغ",
         " فریبا",
         " فریبرز",
         " فرید",
         " فریده",
         " فرین",
         " فهیمه",
         " فواد",
         " فینا",
         " قاسم",
         " قیصر",
         " کاظم",
         " کامران",
         " کبری",
         " کتایون ",
         " کسری",
         " کفایت ",
         " کوثر",
         " کیانا",
         " کیانفر",
         " کیمیا",
         " کیوان",
         " گل مرجان",
         " گلاره",
         " گلناز",
         " گیتا",
         " لاله",
         " لیدا",
         " لیلا",
         " لیلاسادات",
         " مائده",
         " مائده سادات",
         " مارال",
         " ماه منیر",
         " مبینا",
         " مجتبی",
         " مجید",
         " محبوبه",
         " محدثه",
         " محسن",
         " محمد ",
         " محمد اسماعیل",
         " محمد امین",
         " محمد تقی",
         " محمد جواد",
         " محمد حسن",
         " محمد حسین",
         " محمد رضا",
         " محمد سروش",
         " محمد صادق ",
         " محمد علی ",
         " محمد مهدی",
         " محمدامین",
         " محمدباقر",
         " محمدجواد",
         " محمدحامد",
         " محمدحسین",
         " محمدرضا ",
         " محمدعلی",
         " محمدفاضل",
         " محمود",
         " محیا",
         " محیا سادات",
         " مرتضی",
         " مرجان",
         " مرضیه",
         " مروارید",
         " مریم",
         " مریم سادات",
         " مژده",
         " مژگان",
         " مستانه",
         " مسعود",
    ];
    protected static $persian_families = [
         " آغال",
         " آقایی",
         " بغدادی",
         " بهزادی پورگودری ",
         " بهشتی پارچین",
         " خادم پیر ",
         " خالق پور",
         " خلیلی باصری",
         " صبوری",
         " فرهادی",
         " فیروزی",
         " نجائی نصرآباد",
         " آخوندی",
         " آدینه",
         " آدینه پور باقری",
         " آرون",
         " آزرنگ",
         " آشوری",
         " آقاجان پور حیدری",
         " آقایی فرد",
         " ابراهیمی",
         " ابراهیمی خوسفی",
         " ابراهیمیان دستجردی",
         " ابوطالبی",
         " احمدپورمقدم",
         " احمدی",
         " اخلاقی خوش فطرت",
         " استین فشان",
         " اسدی",
         " اسدی سمسکنده",
         " اسعدی",
         " اسکندری میاندوآب",
         " اصلانی",
         " اعرج",
         " افشار",
         " افضلی",
         " اکبری",
         " الله نیاسماکوش",
         " الهامی اصل",
         " امامی",
         " امینی",
         " اناری",
         " انصاری فرد",
         " ایت الهی",
         " ایمانزاده حافظ",
         " اینانلو ",
         " باسامی",
         " باقری",
         " بایمانی",
         " بخش آبادی",
         " بذرافشان",
         " برادران",
         " برادران مفید استانه",
         " برزکار",
         " بغدادی",
         " بنی ابراهیمی",
         " بهاروند",
         " بهرمانی",
         " بیات",
         " پرگاری",
         " پرماس",
         " پروین",
         " پریوش",
         " پشوتن",
         " پلنگی",
         " پهلوان",
         " پور احمد",
         " پوراعتصامی",
         " پورقربان",
         " پویانی پور",
         " تبار",
         " تبرائی نطنزی",
         " ترکاشوند",
         " تعجبی",
         " تقوی طلب",
         " تقی نیا",
         " جعفری حقگو",
         " جلالی",
         " جمالی",
         " جمشیدی",
         " جهانشاهی",
         " جهانی",
         " جوکار ",
         " حاجی میرصادقی",
         " حبیبی نژاد",
         " حسین زاده",
         " حسینی",
         " حسینی عراقی",
         " حق بین",
         " حقی",
         " حمیدی",
         " حیدری",
         " خاتین زاده",
         " خادم",
         " خاک زادی",
         " خاکشوری",
         " خالصی",
         " خداپناه",
         " خدادادی",
         " خدایاری",
         " خدری",
         " خرم دل امروز",
         " خرمی",
         " خشکرودی",
         " خلیل زاد فریوریان",
         " خوش نشین",
         " خیراندیش",
         " دارابی",
         " دارقیاسی",
         " داستانی فر",
         " داودی",
         " دایی علیزاده",
         " درخشان",
         " دررودی",
         " دلدارجانکبری",
         " ده باشی",
         " دیباچی",
         " دیراندریه",
         " ذباح",
         " ذبیحی فاتح بناب",
         " راق",
         " رجبی",
         " رجبی علیایی",
         " رحمانیفام",
         " رحیم پور",
         " ردکا",
         " رسولی لادمخی",
         " رضائی مهر",
         " رضایی منش",
         " رفیع",
         " رمضانی",
         " رمضانیان نیک",
         " رنجبر",
         " رنجبر مقدم",
         " رور",
         " روستایی ",
         " روشن ضمیر",
         " روشندل",
         " ریحانی",
         " زارع",
         " زارعی",
         " زارعی فرد",
         " زرعی",
         " زمانی",
         " زمانی خلیل اباد",
         " زمانی کردشامی",
         " زند",
         " زنگنه",
         " زینلی پور",
         " سادات تکیه",
         " سپهری منش",
         " سرایی صفت",
         " سرخابی",
         " سلطان ابادی",
         " سلطانی",
         " سلطانی سودکلایی",
         " سلیمانپور رکنی",
         " سهرابی ",
         " سید جعفری",
         " سیدی",
         " سیر",
         " شالیها",
         " شجاعی ارانی ",
         " شریفی آبدر",
         " شریفی درآمدی",
         " شفیع پور ",
         " شهابی کارگر",
         " شهروزی",
         " شهسوار ارسون",
         " شورگشتی",
         " شیخ ممو",
         " صالح",
         " صالحی رهنی ",
         " صباغ",
         " صبوری",
         " صحراگرد",
         " صدری فر",
         " صدوقی",
         " صیدمحمدی",
         " ضیاالاسلامی",
         " طالبی الیزئی",
         " عابدی",
         " عابدیزاده",
         " عابدینی",
         " عباسی",
         " عبدالعلی",
         " عبدالهی",
         " عبدلی حسین ابادی",
         " عجمی بختیاروند",
         " عزیزی",
         " علائی",
         " علمداری",
         " علی پور",
         " علی زاده بالوجه میرک",
         " علی نژاد",
         " علیپور",
         " علیمردانی",
         " عمرانی",
         " غضنفری",
         " غفاری",
         " غفوری",
         " غلام علی فرد ",
         " غلامزاده مهابادی",
         " غلامی آبادانی",
         " غلامی پور کبته",
         " غمامی",
         " فاتح",
         " فاتح پور",
         " فتاحی مریم آبادی",
         " فتحی گوهردانی",
         " فراهانی",
         " فرخی",
         " فرخی قلاتی",
         " فرشته حکمت",
         " فرندی",
         " فروتن",
         " فلاح ",
         " فولادوند",
         " قائیدی",
         " قادری",
         " قاسمی",
         " قاسمی شیران",
         " قربان زادی",
         " قربانخانی",
         " قربانی",
         " قریشی سیکایی",
         " قمشاهی",
         " قنبری نیا",
         " قوهستانی",
         " کارگر شورکی",
         " کاووسی",
         " کبادی",
         " کبریایی زاده کچور ستاقی",
         " کردانی",
         " کریمی",
         " کمری",
         " کوهستانی",
         " گروئیانی",
         " گلدی بابایی",
         " گودرزی",
         " لطف الهی خراسانلو",
         " لطفی",
         " مبارکی",
         " مجید ناتری",
         " محبی راد",
         " محسنی",
         " محمد ابادی",
         " محمدخانی",
         " محمدعلیزاده",
         " محمدولیزاده خاتونی",
         " محمدی",
         " محمدی منش",
         " محمدی هشلی",
         " مرادپی",
         " مرادی غریبوند",
         " مرادی مشهود",
         " مردانی کرانی",
         " مردپور",
         " مرشدی اردکانی",
         " مسیحی",
         " مشارزاده",
         " مصدق رنجبر",
         " مصطفی ئی",
         " معصومی",
         " معصومی تکبلاغ",
         " منتظری سانیجی",
         " مهدوی کیا",
         " مهدی",
         " مهربان",
         " مهرعلیان",
         " مهری",
         " موسوی",
         " موسوی جهان اباد",
         " موسوی نیارکی",
         " مولوى خایانى",
         " میر احمدی ",
         " میرزایی",
         " میرصدرایی",
         " میرمحمدی",
         " میری مهرابادی",
         " نباتی خویی",
         " نجفی",
         " نرگه ای",
         " نژاداسلامی",
         " نصر احمدور",
         " نصیری فر",
         " نظری مفرد",
         " نقاش دردشتی",
         " نقدعلی فروشانی",
         " نقوی ",
         " نقیب پور",
         " نور محمدی",
         " نوروزی ",
         " نوری",
         " نویدآذربایجانی",
         " نیازی",
         " نیک فر دستکی",
         " هادی پور قربانعلیها",
         " هنرمند",
         " واحدی",
         " واحدی فرمی",
         " وفایی شوشتری",
         " ولی پور",
         " یاسمنی",
         " یخکشی",
         " یزدی",
         " یعقوبلو",
         " یکتای خشت مسجدی",
         " یوسفی",
         ",کرمی",
         "،ضایی شیرازی",
         ": شفیعی",
         ".رمضانی تاج الدین",
         ".سیاهکلی مرادی",
         ".محمدزاده",
         "۰",
         "۰۰۱مقدم",
         "۱",
         "۱۴۵۱۲۸۰۹۴۷",
         "Bاله وردی زاده",
         "Gharib",
         "Hخوب بخت",
         "jafariyanrostami",
         "koقائدامینی",
         "Saumeie",
         "آ ژ ند",
         "آءینه وند",
         "آئیش",
         "آئین",
         "آئین دار سلیمی",
         "آئین صحرائی",
         "آئین فر",
         "آئینه",
         "آئینه چی",
         "آئینه دار",
         "آئینه زورآب",
         "آئینه ساز",
         "آئینه نگینی",
         "آئینه وند",
         "آئینه‌وند",
         "آئینی",
         "آب آذری",
         "آب آر",
         "آب آور آرانی",
         "آب باریکی",
         "آب باز",
         "آب باز ساداتی",
         "آب ببند نژاد مقدم",
         "آب بخش",
         "آب برین",
         "آب بند پاشاکی",
         "آب پیکر",
         "آب پیکران",
         "آب جام",
         "آب جامه",
         "آب چره",
         "آب چهره",
         "آب حیات",
         "آب خضر",
         "آب خفته",
         "آب خو",
         "آب خوفته",
         "آب خیز",
         "آب دار",
         "آب دانه دستنایی",
         "آب در دیده",
         "آب درجوی",
         "آب دردیده",
         "آب ده",
         "آب دوستی",
         "آب رود ",
         "آب روش",
         "آب روشن ",
         "آب زر",
         "آب سالان",
         "آب سلامه",
         "آب سیه",
         "آب شیرین",
         "آب شیرینی",
         "آب فروش",
         "آب نار",
         "آب نیکی",
         "آب نیلی رنانی",
         "آب و خاک دوست",
         "آب ورز",
         "آب یار",
         "آبا",
         "آبائی",
         "آبائی سنجانی",
         "آبائی هزاوه",
         "آبابائی نیاسری",
         "آباج",
         "آباد",
         "آباد پور",
         "آباد دادخدایی",
         "آبادانی",
         "آبادپور",
         "آبادچی",
         "آبادخیر یامچه",
         "آبادگر چهارده",
         "آباده",
         "آباده ئی",
         "آباده ای",
         "آباده علویجه",
         "آبادهء",
         "آبادی",
         "آبادی باویل",
         "آبادی داریان",
         "آبادی دیزجی",
         "آبادی عباس آباد",
         "آبادی قره بابا",
         "آبادی کلوانق",
         "آبادی هریس",
         "آبادیان",
         "آبادیان زاده",
         "آبادیانی",
         "آبادیخواه",
         "آبار",
         "آباریان",
         "آبافت",
         "آباقری",
         "آبام",
         "آبانگاه",
         "آبانگاه ازگمی",
         "آبایی",
         "آبایی سنجانی",
         "آبایی هزاوه",
         "آببارکی",
         "آبباریکس",
         "آبباریکی",
         "آببرین",
         "آبپر",
         "آبتین",
         "آبتین پور",
         "آبجار",
         "آبجقانی ",
         "آبجو",
         "آبخشت",
         "آبخشک",
         "آبخو",
         "آبخوست",
         "آبخون",
         "آبخیز",
         "آبدار",
         "آبدار اصفهانی",
         "آبداراصفهانی",
         "آبدارباشی",
         "آبداربخشایش",
         "آبداری",
         "آبدونی",
         "آبراری لیمنجوبی",
         "آبروان",
         "آبرود",
         "آبرودوست",
         "آبرودی",
         "آبروش دار",
         "آبروشن",
         "آبرومند",
         "آبرومندی",
         "آبرون",
         "آبرون دارستانی",
         "آبرون دوگاهه",
         "آبرون سیدانی",
         "آبروی",
         "آبرویی",
         "آبز",
         "آبزن",
         "آبزن اردکانی",
         "آبسالان",
         "آبسالان بلداجی",
         "آبسته",
         "آبسری",
         "آبسی",
         "آبشار",
         "آبشاری",
         "آبشاهی",
         "آبشاهی یزدی",
         "آبشتن",
         "آبشتی",
         "آبشگرف",
         "آبشناس",
         "آبشیرینی",
         "آبشینه",
         "آبفروش",
         "آبفروشها",
         "آبق",
         "آبک",
         "آبکار",
         "آبکار اصفهانی",
         "آبکاراصفهانی",
         "آبکتی",
         "آبگر",
         "آبگشا",
         "آبگول",
         "آبگون نیا",
         "آبله کوبها",
         "آبلو",
         "آبلوچ",
    ];



    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }



    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    public static function integer($min = 1, $max = 1000)
    {
        return rand($min, $max);
    }



    public static function persianWord($words = 1)
    {
        //		$array = array_filter(explode(' ' , self::persianTitle () ));
        $source = self::$persian_titles;
        $array  = [];
        foreach ($source as $item) {
            $array = array_merge($array, array_filter(explode(' ', $item)));
        }

        $result = "";
        for ($i = 1; $i <= $words; $i++) {
            $word = $array[rand(0, sizeof($array) - 1)];
            if (strlen($word) < 5) {
                $i--;
                continue;
            }
            $result .= " " . $word;
        }

        return $result;
    }



    public static function persianTitle()
    {
        $array = self::$persian_titles;
        $index = rand(0, sizeof($array) - 1);
        return $array[$index];
    }



    public static function persianName()
    {
        $array = self::$persian_names;
        $index = rand(0, sizeof($array) - 1);
        return $array[$index];
    }



    public static function persianFamily()
    {
        $array = self::$persian_families;
        $index = rand(0, sizeof($array) - 1);
        return $array[$index];
    }



    public static function persianText($paragraphs = 1)
    {
        $text   = self::$persian_text;
        $result = null;
        for ($i = 1; $i <= $paragraphs; $i++) {
            $result .= "\r\n" . $text;
        }

        return $result;
    }



    public static function englishText($paragraphs = 1)
    {
        //		$result = "" ;
        //		for($i=1 ; $i<=$paragraphs ; $i++) {
        //			Artisan::call("inspire") ;
        //			$result .= "\r\n". Artisan::output() ;
        //		}
        //		return $result ;

        $text   = self::$english_text;
        $result = null;
        for ($i = 1; $i <= $paragraphs; $i++) {
            $result .= "\r\n" . $text;
        }

        return $result;
    }



    public static function englishWord($words = 1)
    {
        $result = "";
        for ($i = 1; $i <= $words; $i++) {
            Artisan::call("inspire");
            $array = array_filter(explode(' ', Artisan::output()));

            $word = $array[rand(0, sizeof($array) - 1)];
            if (strlen($word) < 5) {
                $i--;
                continue;
            }
            $result .= " " . $word;
        }

        return $result;
    }



    public static function slug()
    {
        return str_slug(self::englishWord());
    }



    public static function email()
    {
        $email = null;
        while (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email           = self::englishWord() . "@" . self::englishWord();
            $forbidden_chars = ["'", '"', "/", "\\", ",", ".", " "];
            foreach ($forbidden_chars as $forbidden_char) {
                $email = str_replace($forbidden_char, null, $email);
            }

            $email = strtolower($email . ".com");
        }

        return $email;
    }



    public static function mobile()
    {
        $return = "09";

        for ($i = 1; $i <= 9; $i++) {
            $return .= strval(rand(0, 9));
        }

        return $return;
    }



    public static function ip()
    {
        return strval(rand(11, 999)) . '.' . strval(rand(11, 999)) . '.' . strval(rand(11, 999)) . '.' . strval(rand(11,
                  999));
    }



    public static function url()
    {
        return "http://" . trim(strtolower(self::englishWord())) . '.com';
    }
}
