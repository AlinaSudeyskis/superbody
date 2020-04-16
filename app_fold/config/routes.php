<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller']   = 'Welcome';
$route['404_override']         = 'Errors/error_404';
$route['translate_uri_dashes'] = FALSE;

$route['about']       = 'Welcome/about';
$route['contacts']    = 'Welcome/contacts';
$route['unsubscribe'] = 'Welcome/unsubscribe';

//$route['database/create/table'] = 'Database/createTables';

// Авторизация, регистрация
$route['registry']               = 'Authorization/registration';
$route['login']                  = 'Authorization/login';
$route['aRegistry']              = 'Authorization/ajaxUserRegistration';
$route['aLogin']                 = 'Authorization/ajaxUserLogin';
$route['appLogin']               = 'Authorization/appLogin';
$route['appRegistry']            = 'Authorization/appRegistration';
$route['loginViaSocial']         = 'Authorization/loginViaSocial';
$route['instagram_login']        = 'Authorization/instagramLogin';
$route['vk_login']               = 'Authorization/vkLogin';
$route['facebook_login']         = 'Authorization/facebookLogin';
$route['ok_login']               = 'Authorization/okLogin';
//$route['google_login']           = 'Authorization/googleLogin';
$route['logout']                 = 'Authorization/logout';
$route['activate']               = 'Authorization/userActivate';
$route['activated']              = 'Authorization/userActivated';
$route['restore']                = 'Authorization/restorePassword';
$route['block']                  = 'Authorization/blockAccount';
$route['email/change']           = 'Authorization/confirmChangeEmail';
$route['email/changed']          = 'Authorization/confirmChangeEmail/1';
$route['account/restore']        = 'Authorization/restoreAccount';
$route['account/restored']       = 'Authorization/restoreAccount/1';
$route['checkUserEmail']         = 'Authorization/checkUserEmail';

// Страницы пользователя
$route['profile/meals(/(:num)(/(:num)(/(:num))?)?)?'] = 'Course/userMeals/$2/$4/$6';
$route['profile/e_meals']                     = 'Course/adminUserMeals';
$route['profile/courses']                     = 'Course/usersCourses/active';
$route['profile/courses/finished']            = 'Course/usersCourses/finished';
$route['profile/course/(:num)']               = 'Course/usersCourse/$1';
$route['profile/course/(:num)/reviews']       = 'Course/userCourseReviews/$1';
$route['profile/course/(:num)/review/(:num)'] = 'Course/userCourseReview/$1/$2';
$route['profile/course/(:num)/order/(:num)']  = 'Course/userCourseOrder/$1/$2';
$route['profile/course/(:num)/menu']          = 'Course/userNutritionMenu/$1';
$route['profile/(:num)']                      = 'User/profile/$1';
$route['profile']                             = 'User/profile';

$route['settings']               = 'User/settings';
$route['questionnaire(/(anthropometric|progress|parameters|condition|regime))?'] = 'User/userQuestionnaire/$2';
$route['registry/questionnaire'] = 'User/registrationQuestionnaire';
$route['getAnthropometricData(/(:num))?']  = 'User/getAnthropometricData/$2';
$route['getEvents(/(:num))?']    = 'Course/appUserCoursesEvents/$2';
$route['calendar']               = 'Calendar/getUserCalendar';
$route['progress']               = 'User/progress';
$route['cart']                   = 'Store/cart';
$route['ordering']               = 'Store/ordering';
$route['ordering/(:num)']        = 'Store/ordering/$1';
$route['viewed/video']           = 'Course/viewedVideo';
$route['viewing/video']          = 'Course/viewingVideo';
$route['show/video']             = 'Course/showVideo';
$route['show/instruction']       = 'Course/showInstructionVideo';
$route['showMeal']               = 'Course/showMeal';
$route['showMeals']              = 'Course/showMeals';
$route['selectMeal']             = 'Course/selectMeal';
$route['show/workout']           = 'Course/showWorkout';
$route['show/postpone']          = 'Course/showPostpone';
$route['show/userMeal']          = 'Course/showUserMeal';
$route['saveUserMeal']           = 'Course/saveUserMeal';
$route['userSearchMeals']        = 'Course/userSearchMeals';
$route['show/weeks']             = 'Course/showCourseWeeks';
$route['displayCourse']          = 'Course/displayUserCourse';
$route['displayNutrition']       = 'Course/displayUserNutrition';
$route['searchUsers']            = 'User/searchUsers';
$route['searchPromo']            = 'Course/searchCoursePromocode';
$route['checkPromo']             = 'Course/checkPromocode';
$route['activateVideo']          = 'Course/activateCourseVideo';

$route['notifications/nutritionWeekMenu'] = 'Course/sendNutritionWeekMenuEmails';

//$route['buy/course']             = 'Course/buyCourse';
// Записи блога тренера
$route['posts']       = 'Blog/getCoachPosts';
$route['post/new']    = 'Blog/newCoachPost';
$route['post/(:num)'] = 'Blog/getCoachPost/$1';
// Записи блога
$route['blog']        = 'Blog/getPublicPosts';
$route['blog/(:num)'] = 'Blog/getPublicPost/$1';
// Сообщения
$route['messages']        = 'Message/userConversation';
$route['messages/(:num)'] = 'Message/userConversation/$1';
// Обратная связь
$route['messages/feedback'] = 'Message/userConversation/feedback';

// Админ. панель
$route['administration'] = 'Administrator/index';
$route['administration/update/database']        = 'Database/updateDatabase';
$route['administration/show/table/(:any)']      = 'Database/showTable/$1';
$route['administration/show/tables']            = 'Database/showTables';
$route['administration/show/data/table/(:any)(/(:num))?(/(:num))?'] = 'Database/showDataTable/$1/$3/$5';
$route['administration/show/broken'] = 'Database/brokenUsersCourses';
// Администраторы
$route['administration/admins']                = 'Administrator/admins';
$route['administration/admin/new']             = 'Administrator/newAdmin';
$route['administration/admin/new/users']       = 'Administrator/newAdminOfTheUsers';
$route['administration/admin/(:num)/personal'] = 'Administrator/adminSettings/$1/personal';
$route['administration/admin/(:num)']          = 'Administrator/adminSettings/$1';
// Тренеры
$route['administration/coaches']                  = 'Coach/coaches';
$route['administration/coach/new']                = 'Coach/newCoach';
$route['administration/coach/new/users']          = 'Coach/newCoachOfTheUsers';
$route['administration/coach/(:num)/personal']    = 'Coach/coachSettings/$1/personal';
$route['administration/coach/(:num)']             = 'Coach/coachSettings/$1';
$route['administration/coaches/portfolio']        = 'Coach/coachesPortfolioPosts';
$route['administration/coaches/portfolio/(:num)'] = 'Coach/coachesPortfolioPost/$1';
// Пользователи
$route['administration/users(/(auth|bought))?'] = 'User/users/$2';
$route['administration/user/(:num)/personal']   = 'User/userASettings/$1/personal';
$route['administration/user/(:num)/add_course'] = 'User/userASettings/$1/add_course';
$route['administration/user/(:num)']            = 'User/userASettings/$1';
// Подписчики
$route['administration/users/sublist'] = 'Administrator/sublist';
// Архив
$route['administration/users/archive(/(:num))?'] = 'User/archive/$2';
$route['users/delete'] = 'User/deleteUsers';
$route['getSearchUsers'] = 'User/getSearchUsers';
// Видео
/*$route['administration/video']                = 'Course/video/promo';
$route['administration/video/promo']          = 'Course/video/promo';
$route['administration/video/courses']        = 'Course/video/courses';
$route['administration/video/uncategorized']  = 'Course/video/uncategorized';
$route['administration/video/instructions']   = 'Course/video/instructions';
$route['administration/video/course/(:num)']  = 'Course/courseVideo/$1';
$route['administration/video/upload']         = 'Course/newVideo';
$route['administration/video/(:num)']         = 'Course/videoSettings/$1';*/

$route['upload/video']  = 'Course/uploadVideo';
$route['upload/poster'] = 'Course/uploadPoster';
$route['delete/poster'] = 'Course/deletePoster';
$route['delete/video']  = 'Course/deleteVideo';
$route['searchVideo']   = 'Course/searchVideo';

// Тип курса
$route['administration/courses/type']        = 'Course/courseTypes';
$route['administration/courses/type/new']    = 'Course/newCourseTypes';
$route['administration/courses/type/(:num)'] = 'Course/courseType/$1';
// Курс тренировок
$route['administration/courses']         = 'Course/courses/workout';
$route['administration/courses/archive'] = 'Course/courses/workout/1';
$route['administration/course/new']      = 'Course/newCourse';
// Настройки
$route['administration/course/(:num)']          = 'Course/course/$1';
$route['administration/course/(:num)/preview']  = 'Course/coursePreview/$1';
$route['administration/course/(:num)/settings'] = 'Course/course/$1/settings';
// Landing настройки
$route['administration/course/(:num)/landing(/(:num))?'] = 'Course/course/$1/landing/$3';
// Статистика
$route['administration/course/(:num)/statistics'] = 'Course/course/$1/statistics';
// Отзывы
$route['administration/course/(:num)/reviews']       = 'Course/course/$1/reviews';
$route['administration/course/(:num)/review/(:num)'] = 'Course/course/$1/review/$2';
// Настройки видео курса
$route['administration/course/(:num)/video']              = 'Course/course/$1/video_promo';
$route['administration/course/(:num)/video/promo']        = 'Course/course/$1/video_promo';
$route['administration/course/(:num)/video/workouts']     = 'Course/course/$1/video_workouts';
$route['administration/course/(:num)/video/instructions'] = 'Course/course/$1/video_instructions';
$route['administration/course/(:num)/video/uncategorized'] = 'Course/course/$1/video_uncategorized';
$route['administration/course/(:num)/video/new']          = 'Course/newCourseVideo/$1';
$route['administration/course/(:num)/video/(:num)']       = 'Course/courseVideoSettings/$1/$2';
// Курсы продления
$route['administration/course/(:num)/extends']       = 'Course/course/$1/extends';
$route['administration/course/(:num)/extend/new']    = 'Course/course/$1/extend_new';
$route['administration/course/(:num)/extend/(:num)'] = 'Course/course/$1/extend/$2';
// Прикрепленные курсы
$route['administration/course/(:num)/attached']   = 'Course/course/$1/attached';
$route['administration/course/(:num)/attach/new'] = 'Course/course/$1/attach_new';
// Активность клиентов
$route['administration/course/(:num)/clients']       = 'Course/courseUsersActivity/$1';
$route['administration/course/(:num)/client/(:num)'] = 'Course/courseUserActivity/$1/$2';

// Курс питания
$route['administration/nutritions']                = 'Course/courses/nutrition';
$route['administration/nutritions/archive']        = 'Course/courses/nutrition/1';
$route['administration/nutrition/new']             = 'Course/newNutrition';
// Настройки
$route['administration/nutrition/(:num)']          = 'Course/nutrition/$1/settings';
$route['administration/nutrition/(:num)/preview']  = 'Course/coursePreview/$1';
$route['administration/nutrition/(:num)/settings'] = 'Course/nutrition/$1/settings';
// Landing настройки
$route['administration/nutrition/(:num)/landing(/(:num))?'] = 'Course/nutrition/$1/landing/$3';
// Статистика
$route['administration/nutrition/(:num)/statistics'] = 'Course/nutrition/$1/statistics';
// Отзывы
$route['administration/nutrition/(:num)/reviews']       = 'Course/nutrition/$1/reviews';
$route['administration/nutrition/(:num)/review/(:num)'] = 'Course/nutrition/$1/review/$2';
// Промокоды
$route['administration/promocodes']       = 'Course/promocodes';
$route['administration/promocode/new']    = 'Course/newPromocode';
$route['administration/promocode/(:num)'] = 'Course/promocode/$1';
$route['administration/coaches/promocodes']      = 'Course/coachesPromocodes';
$route['administration/coach/promocodes/(:num)'] = 'Course/coachPromocodes/$1';
$route['searchCourses'] = 'Course/searchCourses';
$route['saveFriendPromocode'] = 'Course/saveFriendPromocode';
// Тип приемов пищи
/*$route['administration/ingestion/type']        = 'Course/ingestionTypes';
$route['administration/ingestion/type/new']    = 'Course/newIngestionTypes';
$route['administration/ingestion/type/(:num)'] = 'Course/ingestionType/$1';*/
// Блюда
$route['administration/meals']       = 'Course/meals';
$route['administration/meal/new']    = 'Course/newMeal';
$route['administration/meal/import'] = 'Course/importMeals';
$route['administration/meal/(:num)'] = 'Course/meal/$1';

$route['searchMeals']       = 'Course/searchMeals';
$route['searchIngredients'] = 'Course/searchIngredients';
// Тип блюда
$route['administration/meals/types']       = 'Course/mealsTypes';
$route['administration/meals/type/new']    = 'Course/newMealsType';
$route['administration/meals/type/(:num)'] = 'Course/mealsType/$1';
// Прием пищи
$route['administration/ingestions']       = 'Course/ingestions';
$route['administration/ingestion/new']    = 'Course/newIngestion';
$route['administration/ingestion/(:num)'] = 'Course/ingestion/$1';

// Записи блога
$route['administration/blog/posts']          = 'Blog/blogPosts';
$route['administration/blog/post/(:num)']    = 'Blog/blogPost/$1';
$route['administration/blog/comments']       = 'Blog/blogComments';
$route['administration/blog/comment/(:num)'] = 'Blog/blogComment/$1';
$route['upload_post_images'] = 'Blog/postUploadImage';
// Сообщения
$route['administration/messages']        = 'Message/messages';
$route['administration/message/(:num)']  = 'Message/message/$1';
$route['administration/feedback']        = 'Message/feedbackMessages';
$route['administration/feedback/(:any)'] = 'Message/feedbackUserMessages/$1';
// Вопрос - Ответ
$route['administration/question-answer']                   = 'Message/eQuestionAnswer';
$route['administration/question-answer/new']               = 'Message/eQaNewArticle';
$route['administration/question-answer/sections']          = 'Message/eQaSections';
$route['administration/question-answer/section/new']       = 'Message/eQaNewSection';
$route['administration/question-answer/section/(:num)']    = 'Message/eQaSection/$1';
$route['administration/question-answer/subsection/new']    = 'Message/eQaNewSubsection';
$route['administration/question-answer/subsection/(:num)'] = 'Message/eQaSubsection/$1';
$route['administration/question-answer/(:num)']            = 'Message/eQaArticle/$1';
$route['upload_qa_images'] = 'Message/eQaUploadImage';

$route['support'] = 'Message/QaSections';
$route['support/(:num)(/(:num))?']     = 'Message/QaSection/$1/$3';
$route['support/(:num)/(:num)/(:num)'] = 'Message/QaArticle/$1/$2/$3';
// Информация о сайте
$route['administration/site'] = 'Administrator/siteInfo';
$route['administration/site/(header|banner|about|contacts|auth|spec|meta|cookies)'] = 'Administrator/siteInfo/$1';
$route['administration/site/banner/new']    = 'Administrator/newBanner';
$route['administration/site/banner/(:num)'] = 'Administrator/siteBanner/$1';
// Уведомления и письма
$route['administration/notifications']          = 'Notification/notifications';
$route['administration/notification/(:num)']    = 'Notification/notification/$1';
$route['administration/emails']                 = 'Notification/emails';
$route['administration/emails/addresses']       = 'Notification/emailsAddresses';
$route['administration/emails/addresses/new']   = 'Notification/newEmailAddress';
$route['administration/email/address/(:num)']   = 'Notification/emailAddress/$1';
$route['administration/email/(:num)']           = 'Notification/email/$1';
$route['administration/email_sample(/(:num))?'] = 'Notification/emailSample/$2';
$route['sendTokenToServer']                     = 'Notification/setToken';
$route['testBrowserNotifications']              = 'Notification/sendBrowserNotifications';
// Журнал
//$route['administration/journal']     = 'Journal/journalList';
//$route['administration/journal/new']    = 'Journal/journalNew';
//$route['administration/journal/(:num)'] = 'Journal/journalPost/$1';
//$route['upload/journal/images']         = 'Journal/uploadImages';
//$route['deleteJournalImage']            = 'Journal/deleteImage';
//$route['administration/journal/(articles|interviews|news)'] = 'Journal/journalPosts/$1';
// Статьи
//$route['administration/journal/articles']       = 'Journal/journalArticles';
//$route['administration/journal/article/new']    = 'Journal/journalNewArticle';
//$route['administration/journal/article/(:num)'] = 'Journal/journalArticle/$1';
// Интервью
//$route['administration/journal/interviews']       = 'Journal/journalInterviews';
//$route['administration/journal/interview/new']    = 'Journal/journalNewInterview';
//$route['administration/journal/interview/(:num)'] = 'Journal/journalInterview/$1';
// Новости
//$route['administration/journal/news']        = 'Journal/journalNews';
//$route['administration/journal/news/new']    = 'Journal/journalNewNews';
//$route['administration/journal/news/(:num)'] = 'Journal/journalNews/$1';

// Категории и подкатегории товаров
$route['administration/categories']             = 'Store/categories';
$route['administration/category/new']           = 'Store/newCategory';
$route['administration/category/(:num)']        = 'Store/category/$1';
$route['administration/category/(:num)/new']    = 'Store/newSubcategory/$1';
$route['administration/category/(:num)/(:num)'] = 'Store/subcategory/$1/$2';
// Интернет-магазин
$route['administration/store']                = 'Store/products';
$route['administration/store/product/new']    = 'Store/newProduct';
$route['administration/store/product/(:num)'] = 'Store/product/$1';
$route['administration/orders(/(capture|succeeded|canceled|pending|refunded|revoke|free|unpaid))?'] = 'Store/orders/$2';
$route['administration/order/(:num)']         = 'Store/order/$1';
//$route['orders']                              = 'Store/userOrders';
//$route['order/(:num)']                        = 'Store/userOrder/$1';
$route['getSubcategories']                    = 'Store/getSubcategories';
$route['searchProduct']                       = 'Store/searchProduct';
// Landing
$route['administration/landing/default/(:num)'] = 'Course/defaultLanding/$1';
$route['landing/(:num)']                        = 'Course/landing/$1';

// Страница тренера
$route['profile/promocodes']       = 'Coach/coachPromocodes';
$route['profile/promocode/new']    = 'Coach/coachNewPromocode';
$route['profile/promocode/(:num)'] = 'Coach/coachPromocode/$1';
$route['portfolio']                = 'Coach/coachPortfolio';
$route['portfolio/(:num)']         = 'Coach/portfolioPost/$1';
$route['portfolio/post/(:num)']    = 'Coach/editPortfolioPost/$1';
$route['portfolio/post/new']       = 'Coach/newPortfolioPost';
$route['searchCoaches']            = 'Coach/searchCoaches';
$route['partner']                  = 'Coach/partner';
$route['partner/course/(:num)']    = 'Coach/partnerCourse/$1';
$route['clients/activity']         = 'Coach/usersActivity';
$route['client/activity/(:num)']   = 'Coach/userActivity/$1';
$route['coaches']                  = 'Coach/publicCoaches';

// Курс
$route['course/(:num)'] = 'Course/publicCourse/$1';
$route['courses']       = 'Course/publicCourses';
$route['courses/(workouts|nutritions)(/(:num))?'] = 'Course/publicCourses/$1/$3';
$route['courses/coaches/(:num)/(workouts|nutritions)/(:num)'] = 'Course/publicCourses/$2/$3/crs_coaches/$1';
$route['courses/coaches(/(:num))?'] = 'Course/publicCourses///crs_coaches/$2';
$route['courses/promocode/(:any)/(workouts|nutritions)/(:num)'] = 'Course/publicCourses/$2/$3/promocode/$1';
$route['courses/promocode/(:any)'] = 'Course/publicCourses///promocode/$1';
$route['buy_course'] = 'Course/buyCourseForm';

$route['sortCourses'] = 'Course/getSortCourses';

// Оплата
$route['payment']                     = 'Payment/payment';
$route['payment/notifications']       = 'Payment/paymentNotifications';
$route['payment/update']              = 'Payment/paymentUpdate';
$route['payment/userWaitingPayments'] = 'Payment/checkUserWaitingPayments';

// Журнал
//$route['journal/articles']         = 'Journal/articles';
//$route['journal/article/(:num)']   = 'Journal/article/$1';
//$route['journal/interviews']       = 'Journal/interviews';
//$route['journal/interview/(:num)'] = 'Journal/interview/$1';
//$route['journal/news']             = 'Journal/news';
//$route['journal/news/(:num)']      = 'Journal/news/$1';

// Интернет-магазин
$route['store']                       = 'Store/store';
$route['store/(:num)']                = 'Store/store/$1';
$route['store/product/(:num)']        = 'Store/storeProduct/$1';
$route['store/(:num)/product/(:num)'] = 'Store/storeProduct/$2/$1';

$route['addProductToCart']       = 'Store/productToCart';
$route['addCourseToCart']        = 'Store/courseToCart';
$route['dataCourse']             = 'Course/getAvailableDataCourse';
$route['deleteCartProduct']      = 'Store/deleteCartProduct';
$route['detachCartProducts']     = 'Store/detachCartProducts';
$route['updateCartProduct']      = 'Store/updateCartProduct';
$route['sortProducts']           = 'Store/getSortProducts';
$route['getSearchProducts']      = 'Store/getSearchProducts';
$route['getSearchNotifications'] = 'Notification/getSearchNotifications';
$route['loginForm']              = 'Authorization/getLoginForm';

// Cron
$route['payment/verification']        = 'Payment/verificationSubsequentPayments';
$route['course/coursesFreeWeeks']     = 'Course/checkUsersCoursesFreeWeeks';
$route['course/usersWorkouts']        = 'Course/checkUsersWorkouts';
$route['course/usersExpiringCourses'] = 'Course/checkUsersExpiringCourses';
$route['course/revokedUsersCourses']  = 'Course/checkRevokedUsersCourses';