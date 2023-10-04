## About Admin Panel
Это вполне рабочий модуль авторизации на сайте. Работает на Open Sever. Через компосер установил модули  twig, fast-route. 
Использовал модуль PHPMailer.
Таблица 
для хранения юзеров примерно такая
CREATE TABLE `usera` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verified` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk_token` varchar(255) COLLATE utf8mb4_unicode_ci,
  `up_creat` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

Отвечу на вопросы: romanenko@inbox.ru

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
