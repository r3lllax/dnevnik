<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        DB::table('roles')->insert([
            ['name' => 'Администратор'],
            ['name' => 'Учитель'],
            ['name' => 'Студент'],
        ]);

        DB::table('groups')->insert([
            [
                'name' => '1-ГД-8'
            ],
            [
                'name' => '1-Д-38'
            ],
            [
                'name' => '1-ИЗ-27'
            ],
            [
                'name' => '1-ИС-8'
            ],
            [
                'name' => '1-КМ-39'
            ],
            [
                'name' => '1-ОН-1'
            ],
            [
                'name' => '1-ПП-2'
            ],
            [
                'name' => '1-Р-25'
            ],
            [
                'name' => '1-СА-8'
            ],
            [
                'name' => '1-СА-9'
            ],
            [
                'name' => '1-Т-13'
            ],
            [
                'name' => '2-Бух-48'
            ],
            [
                'name' => '2-ГД-7'
            ],
            [
                'name' => '2-Д-37'
            ],
            [
                'name' => '2-ИЗ-26'
            ],
            [
                'name' => '2-ИС-7'
            ],
            [
                'name' => '2-КМ-38'
            ],
            [
                'name' => '2-МС-1'
            ],
            [
                'name' => '2-ПП-1'
            ],
            [
                'name' => '2-Р-24'
            ],
            [
                'name' => '2-СА-7'
            ],
            [
                'name' => '2-Т-12'
            ],
            [
                'name' => '2-ТД-1'
            ],
            [
                'name' => '3-БК-1'
            ],
            [
                'name' => '3-БУХ-47'
            ],
            [
                'name' => '3-Д-36'
            ],
            [
                'name' => '3-ИЗ-25'
            ],
            [
                'name' => '3-ИС-6'
            ],
            [
                'name' => '3-К-42'
            ],
            [
                'name' => '3-КМ-37'
            ],
            [
                'name' => '3-ПД-6'
            ],
            [
                'name' => '3-Р-23'
            ],
            [
                'name' => '3-СА-6'
            ],
            [
                'name' => '3-Т-11'
            ],
            [
                'name' => '3-ТВ-9'
            ],
            [
                'name' => '3-Ф-6'
            ],
            [
                'name' => '4-БУХ-46'
            ],
            [
                'name' => '4-Д-35'
            ],
            [
                'name' => '4-ИЗ-24'
            ],
            [
                'name' => '4-ИС-5'
            ],
            [
                'name' => '4-КМ-36'
            ],
            [
                'name' => '4-ПД-5'
            ],
            [
                'name' => '4-Р-22'
            ],
            [
                'name' => '4-СА-5'
            ],
            [
                'name' => '4-Т-10'
            ]
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Иван', 'surname' => 'Иванов', 'patronymic' => 'Иванович',
                'login'=>'ivanov',
                'phone_number' => '+79998887766', 'email' => 'ivanov@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2003-05-10', 'img_path' => '/images/users/1.jpg',
                'group_id' => 1, 'role_id' => 3,
            ],
            [
                'name' => 'Пётр', 'surname' => 'Петров', 'patronymic' => 'Петрович',
                'login'=>'petrov',
                'phone_number' => '+79995554433', 'email' => 'petrov@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2002-11-22', 'img_path' => '/images/users/2.jpg',
                'group_id' => 1, 'role_id' => 2,
            ],
            [
                'name' => 'Мария', 'surname' => 'Сидорова', 'patronymic' => 'Игоревна',
                'login'=>'sidorova',
                'phone_number' => '+79990001122', 'email' => 'sidorova@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2004-03-15', 'img_path' => '/images/users/3.jpg',
                'group_id' => 2, 'role_id' => 3,
            ],
            [
                'name' => 'Ольга', 'surname' => 'Кузнецова', 'patronymic' => 'Сергеевна',
                'login'=>'kuznecova',
                'phone_number' => '+79991234567', 'email' => 'kuznetsova@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '1990-09-01', 'img_path' => '/images/users/4.jpg',
                'group_id' => 3, 'role_id' => 2,
            ],
            [
                'name' => 'Елена', 'surname' => 'Морозова', 'patronymic' => 'Викторовна',
                'login'=>'morozova',
                'phone_number' => '+79994443322', 'email' => 'morozova@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '1991-12-05', 'img_path' => '/images/users/5.jpg',
                'group_id' => 4, 'role_id' => 2,
            ],
            [
                'name' => 'Кирилл', 'surname' => 'Смирнов', 'patronymic' => 'Алексеевич',
                'login'=>'smirnov',
                'phone_number' => '+79995556677', 'email' => 'smirnov@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2003-10-10', 'img_path' => '/images/users/6.jpg',
                'group_id' => 5, 'role_id' => 3,
            ],
            [
                'name' => 'Сергей', 'surname' => 'Волков', 'patronymic' => 'Андреевич',
                'login'=>'volkov',
                'phone_number' => '+79996667788', 'email' => 'volkov@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2004-06-20', 'img_path' => '/images/users/7.jpg',
                'group_id' => 5, 'role_id' => 3,
            ],
            [
                'name' => 'Анна', 'surname' => 'Николаева', 'patronymic' => 'Владимировна',
                'login'=>'nikolaeva',
                'phone_number' => '+79997778899', 'email' => 'nikolaeva@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '1995-02-01', 'img_path' => '/images/users/8.jpg',
                'group_id' => 6, 'role_id' => 2,
            ],
            [
                'name' => 'Дмитрий', 'surname' => 'Орлов', 'patronymic' => 'Петрович',
                'login'=>'orlov',
                'phone_number' => '+79998889900', 'email' => 'orlov@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2001-04-18', 'img_path' => '/images/users/9.jpg',
                'group_id' => 7, 'role_id' => 3,
            ],
            [
                'name' => 'Александр', 'surname' => 'Фёдоров', 'patronymic' => 'Михайлович',
                'login'=>'fedorov',
                'phone_number' => '+79991112233', 'email' => 'fedorov@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2002-08-30', 'img_path' => '/images/users/10.jpg',
                'group_id' => 8, 'role_id' => 3,
            ],
            [
                'name' => 'Андрей', 'surname' => 'Сергеев', 'patronymic' => 'Владимирович',
                'login'=>'sergeev',
                'phone_number' => '+79990000001', 'email' => 'admin1@mail.ru',
                'password' => bcrypt('admin123'),
                'birth_date' => '1985-03-05', 'img_path' => '/images/users/admin1.jpg',
                'group_id' => 1, 'role_id' => 1,
            ],
            [
                'name' => 'Татьяна', 'surname' => 'Фомина', 'patronymic' => 'Игоревна',
                'login'=>'fomina',
                'phone_number' => '+79990000002', 'email' => 'admin2@mail.ru',
                'password' => bcrypt('admin123'),
                'birth_date' => '1983-07-12', 'img_path' => '/images/users/admin2.jpg',
                'group_id' => 1, 'role_id' => 1,
            ],
            [
                'name' => 'Иван', 'surname' => 'Иванов', 'patronymic' => 'Иванович',
                'login'=>'ivanov2',
                'phone_number' => '+79998887766', 'email' => 'ivanov2@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2003-05-10', 'img_path' => '/images/users/1.jpg',
                'group_id' => 1, 'role_id' => 3,
            ],
            [
                'name' => 'Мария', 'surname' => 'Сидорова', 'patronymic' => 'Игоревна',
                'login'=>'sidorova2',
                'phone_number' => '+79990001122', 'email' => 'sidorova2@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2004-03-15', 'img_path' => '/images/users/3.jpg',
                'group_id' => 2, 'role_id' => 3,
            ],
            [
                'name' => 'Кирилл', 'surname' => 'Смирнов', 'patronymic' => 'Алексеевич',
                'login'=>'smirnov2',
                'phone_number' => '+79995556677', 'email' => 'smirnov3@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2003-10-10', 'img_path' => '/images/users/6.jpg',
                'group_id' => 5, 'role_id' => 3,
            ],
            [
                'name' => 'Сергей', 'surname' => 'Волков', 'patronymic' => 'Андреевич',
                'login'=>'volkov2',
                'phone_number' => '+79996667788', 'email' => 'volkov11@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2004-06-20', 'img_path' => '/images/users/7.jpg',
                'group_id' => 5, 'role_id' => 3,
            ],
            [
                'name' => 'Дмитрий', 'surname' => 'Орлов', 'patronymic' => 'Петрович',
                'login'=>'orlov2',
                'phone_number' => '+79998889900', 'email' => 'orlov2@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2001-04-18', 'img_path' => '/images/users/9.jpg',
                'group_id' => 7, 'role_id' => 3,
            ],
            [
                'name' => 'Александр', 'surname' => 'Фёдоров', 'patronymic' => 'Михайлович',
                'login'=>'fedorov2',
                'phone_number' => '+79991112233', 'email' => 'fedorov4@mail.ru',
                'password' => bcrypt('password'),
                'birth_date' => '2002-08-30', 'img_path' => '/images/users/10.jpg',
                'group_id' => 8, 'role_id' => 3,
            ],
        ]);



        DB::table('semesters')->insert([
            ['name' => 'Семестр 1', 'from' => '2025-09-01', 'to' => '2025-12-31'],
            ['name' => 'Семестр 2', 'from' => '2025-01-15', 'to' => '2025-05-31'],
        ]);

        DB::table('works_types')->insert([
            ['name' => 'Домашняя работа'],
            ['name' => 'Контрольная'],
            ['name' => 'Лабораторная работа'],
            ['name' => 'Курсовой проект'],
            ['name' => 'Практическая работа'],
            ['name' => 'Тест'],
            ['name' => 'Самостоятельная'],
            ['name' => 'Экзамен'],
            ['name' => 'Зачёт'],
            ['name' => 'Реферат'],
            ['name' => 'Остальное'],
        ]);

        DB::table('subjects')->insert([
            ['name' => 'Математика', 'teacher_id' => 3],
            ['name' => 'Информатика', 'teacher_id' => 4],
            ['name' => 'Физика', 'teacher_id' => 5],
            ['name' => 'История', 'teacher_id' => 6],
            ['name' => 'Экономика', 'teacher_id' => 4],
            ['name' => 'Программирование', 'teacher_id' => 3],
            ['name' => 'Базы данных', 'teacher_id' => 5],
            ['name' => 'ОСиС', 'teacher_id' => 3],
            ['name' => 'Английский язык', 'teacher_id' => 6],
            ['name' => 'Философия', 'teacher_id' => 4],
        ]);

        DB::table('rooms')->insert([
            ['name' => '101'],
            ['name' => '102'],
            ['name' => '103'],
            ['name' => '104'],
            ['name' => '201'],
            ['name' => '202'],
            ['name' => '203'],
            ['name' => '204'],
            ['name' => '301'],
            ['name' => '302'],
        ]);

        DB::table('subjects_times')->insert([
            ['start_time' => '08:30:00', 'end_time' => '10:05:00'],
            ['start_time' => '10:15:00', 'end_time' => '11:50:00'],
            ['start_time' => '12:20:00', 'end_time' => '13:55:00'],
            ['start_time' => '14:05:00', 'end_time' => '15:40:00'],
            ['start_time' => '16:00:00', 'end_time' => '17:35:00'],
            ['start_time' => '17:45:00', 'end_time' => '19:20:00'],
            ['start_time' => '19:30:00', 'end_time' => '20:05:00'],
        ]);

        DB::table('groups_subjects')->insert([
            ['group_id' => 1, 'subject_id' => 1],
            ['group_id' => 1, 'subject_id' => 2],
            ['group_id' => 2, 'subject_id' => 3],
            ['group_id' => 2, 'subject_id' => 6],
            ['group_id' => 3, 'subject_id' => 7],
            ['group_id' => 4, 'subject_id' => 8],
            ['group_id' => 5, 'subject_id' => 1],
            ['group_id' => 6, 'subject_id' => 2],
            ['group_id' => 7, 'subject_id' => 5],
            ['group_id' => 8, 'subject_id' => 9],
        ]);


        // --- Расписание занятий (3 недели) ---
        DB::table('schedule')->insert([
            // ===== Группа 1 (6-дневка) =====
            ['group_id' => 1, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 1, 'room_id' => 1, 'date' => '2025-03-10', 'comment' => 'Повторение формул', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 2, 'room_id' => 2, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 7, 'teacher_id' => 5, 'time_id' => 3, 'room_id' => 3, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],

            ['group_id' => 1, 'subject_id' => 3, 'teacher_id' => 5, 'time_id' => 1, 'room_id' => 3, 'date' => '2025-03-11', 'comment' => 'Лабораторная работа', 'highlight' => true],
            ['group_id' => 1, 'subject_id' => 10, 'teacher_id' => 4, 'time_id' => 2, 'room_id' => 4, 'date' => '2025-03-11', 'comment' => '', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 9, 'teacher_id' => 8, 'time_id' => 3, 'room_id' => 5, 'date' => '2025-03-11', 'comment' => '', 'highlight' => false],

            ['group_id' => 1, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 1, 'room_id' => 1, 'date' => '2025-03-12', 'comment' => '', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 6, 'teacher_id' => 2, 'time_id' => 2, 'room_id' => 2, 'date' => '2025-03-12', 'comment' => 'Практическая работа', 'highlight' => true],
            ['group_id' => 1, 'subject_id' => 5, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 4, 'date' => '2025-03-12', 'comment' => '', 'highlight' => false],

            ['group_id' => 1, 'subject_id' => 8, 'teacher_id' => 2, 'time_id' => 1, 'room_id' => 5, 'date' => '2025-03-13', 'comment' => '', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 2, 'room_id' => 2, 'date' => '2025-03-13', 'comment' => 'Подготовка к контрольной', 'highlight' => true],

            ['group_id' => 1, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 1, 'room_id' => 1, 'date' => '2025-03-14', 'comment' => '', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 10, 'teacher_id' => 4, 'time_id' => 4, 'room_id' => 4, 'date' => '2025-03-14', 'comment' => '', 'highlight' => false],

            ['group_id' => 1, 'subject_id' => 7, 'teacher_id' => 5, 'time_id' => 1, 'room_id' => 3, 'date' => '2025-03-15', 'comment' => 'Контрольная работа', 'highlight' => true],

            // 2 неделя
            ['group_id' => 1, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 1, 'room_id' => 1, 'date' => '2025-03-17', 'comment' => '', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 3, 'teacher_id' => 5, 'time_id' => 2, 'room_id' => 3, 'date' => '2025-03-17', 'comment' => '', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 6, 'teacher_id' => 2, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-17', 'comment' => '', 'highlight' => false],

            ['group_id' => 1, 'subject_id' => 9, 'teacher_id' => 8, 'time_id' => 2, 'room_id' => 5, 'date' => '2025-03-18', 'comment' => '', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 5, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 4, 'date' => '2025-03-18', 'comment' => '', 'highlight' => false],

            ['group_id' => 1, 'subject_id' => 7, 'teacher_id' => 5, 'time_id' => 1, 'room_id' => 3, 'date' => '2025-03-19', 'comment' => 'Практическая', 'highlight' => true],
            ['group_id' => 1, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 2, 'room_id' => 2, 'date' => '2025-03-19', 'comment' => '', 'highlight' => false],

            ['group_id' => 1, 'subject_id' => 10, 'teacher_id' => 4, 'time_id' => 1, 'room_id' => 4, 'date' => '2025-03-20', 'comment' => '', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 2, 'room_id' => 1, 'date' => '2025-03-20', 'comment' => 'Разбор задач', 'highlight' => true],

            ['group_id' => 1, 'subject_id' => 9, 'teacher_id' => 8, 'time_id' => 3, 'room_id' => 5, 'date' => '2025-03-21', 'comment' => '', 'highlight' => false],
            ['group_id' => 1, 'subject_id' => 6, 'teacher_id' => 2, 'time_id' => 4, 'room_id' => 2, 'date' => '2025-03-21', 'comment' => '', 'highlight' => false],

            ['group_id' => 1, 'subject_id' => 3, 'teacher_id' => 5, 'time_id' => 2, 'room_id' => 3, 'date' => '2025-03-22', 'comment' => 'Лабораторная', 'highlight' => true],

            // ===== Группа 2 (6-дневка) =====
            ['group_id' => 2, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 1, 'room_id' => 2, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],
            ['group_id' => 2, 'subject_id' => 4, 'teacher_id' => 8, 'time_id' => 2, 'room_id' => 4, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],
            ['group_id' => 2, 'subject_id' => 9, 'teacher_id' => 8, 'time_id' => 3, 'room_id' => 5, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],

            ['group_id' => 2, 'subject_id' => 6, 'teacher_id' => 2, 'time_id' => 1, 'room_id' => 2, 'date' => '2025-03-11', 'comment' => '', 'highlight' => false],
            ['group_id' => 2, 'subject_id' => 5, 'teacher_id' => 4, 'time_id' => 2, 'room_id' => 4, 'date' => '2025-03-11', 'comment' => '', 'highlight' => false],
            ['group_id' => 2, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 3, 'room_id' => 1, 'date' => '2025-03-11', 'comment' => 'Разбор задач', 'highlight' => true],

            ['group_id' => 2, 'subject_id' => 10, 'teacher_id' => 4, 'time_id' => 1, 'room_id' => 4, 'date' => '2025-03-12', 'comment' => '', 'highlight' => false],
            ['group_id' => 2, 'subject_id' => 7, 'teacher_id' => 5, 'time_id' => 2, 'room_id' => 3, 'date' => '2025-03-12', 'comment' => 'Практическая', 'highlight' => true],

            ['group_id' => 2, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-13', 'comment' => '', 'highlight' => false],
            ['group_id' => 2, 'subject_id' => 4, 'teacher_id' => 8, 'time_id' => 4, 'room_id' => 4, 'date' => '2025-03-13', 'comment' => 'Тест по истории', 'highlight' => true],

            ['group_id' => 2, 'subject_id' => 9, 'teacher_id' => 8, 'time_id' => 2, 'room_id' => 5, 'date' => '2025-03-14', 'comment' => '', 'highlight' => false],
            ['group_id' => 2, 'subject_id' => 6, 'teacher_id' => 2, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-14', 'comment' => '', 'highlight' => false],

            ['group_id' => 2, 'subject_id' => 3, 'teacher_id' => 5, 'time_id' => 2, 'room_id' => 3, 'date' => '2025-03-15', 'comment' => 'Лабораторная работа', 'highlight' => true],

            // --- Продолжение расписания (Группы 3, 4, 5) ---

// ===== Группа 3 (6-дневка) =====
            ['group_id' => 3, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 1, 'room_id' => 1, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 3, 'teacher_id' => 5, 'time_id' => 2, 'room_id' => 3, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 5, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 4, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],

            ['group_id' => 3, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 1, 'room_id' => 2, 'date' => '2025-03-11', 'comment' => 'Контрольная по информатике', 'highlight' => true],
            ['group_id' => 3, 'subject_id' => 9, 'teacher_id' => 8, 'time_id' => 2, 'room_id' => 5, 'date' => '2025-03-11', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 10, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 4, 'date' => '2025-03-11', 'comment' => '', 'highlight' => false],

            ['group_id' => 3, 'subject_id' => 4, 'teacher_id' => 8, 'time_id' => 1, 'room_id' => 4, 'date' => '2025-03-12', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 2, 'room_id' => 1, 'date' => '2025-03-12', 'comment' => 'Разбор задач', 'highlight' => true],

            ['group_id' => 3, 'subject_id' => 6, 'teacher_id' => 2, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-13', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 7, 'teacher_id' => 5, 'time_id' => 4, 'room_id' => 3, 'date' => '2025-03-13', 'comment' => 'Практическая работа', 'highlight' => true],

            ['group_id' => 3, 'subject_id' => 9, 'teacher_id' => 8, 'time_id' => 1, 'room_id' => 5, 'date' => '2025-03-14', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 5, 'teacher_id' => 4, 'time_id' => 2, 'room_id' => 4, 'date' => '2025-03-14', 'comment' => '', 'highlight' => false],

            ['group_id' => 3, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 3, 'room_id' => 1, 'date' => '2025-03-15', 'comment' => 'Контрольная работа', 'highlight' => true],

            ['group_id' => 3, 'subject_id' => 10, 'teacher_id' => 4, 'time_id' => 1, 'room_id' => 4, 'date' => '2025-03-17', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 7, 'teacher_id' => 5, 'time_id' => 2, 'room_id' => 3, 'date' => '2025-03-17', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-17', 'comment' => '', 'highlight' => false],

            ['group_id' => 3, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 1, 'room_id' => 1, 'date' => '2025-03-18', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 4, 'teacher_id' => 8, 'time_id' => 2, 'room_id' => 4, 'date' => '2025-03-18', 'comment' => '', 'highlight' => false],

            ['group_id' => 3, 'subject_id' => 6, 'teacher_id' => 2, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-19', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 5, 'teacher_id' => 4, 'time_id' => 4, 'room_id' => 4, 'date' => '2025-03-19', 'comment' => 'Практика', 'highlight' => true],

            ['group_id' => 3, 'subject_id' => 9, 'teacher_id' => 8, 'time_id' => 1, 'room_id' => 5, 'date' => '2025-03-20', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 3, 'teacher_id' => 5, 'time_id' => 2, 'room_id' => 3, 'date' => '2025-03-20', 'comment' => 'Лабораторная', 'highlight' => true],

            ['group_id' => 3, 'subject_id' => 10, 'teacher_id' => 4, 'time_id' => 1, 'room_id' => 4, 'date' => '2025-03-21', 'comment' => '', 'highlight' => false],
            ['group_id' => 3, 'subject_id' => 7, 'teacher_id' => 5, 'time_id' => 2, 'room_id' => 3, 'date' => '2025-03-21', 'comment' => '', 'highlight' => false],

            ['group_id' => 3, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-22', 'comment' => 'Контрольная работа', 'highlight' => true],


            // ===== Группа 4 (5-дневка) =====
            ['group_id' => 4, 'subject_id' => 4, 'teacher_id' => 8, 'time_id' => 1, 'room_id' => 4, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],
            ['group_id' => 4, 'subject_id' => 5, 'teacher_id' => 4, 'time_id' => 2, 'room_id' => 4, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],
            ['group_id' => 4, 'subject_id' => 6, 'teacher_id' => 2, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-10', 'comment' => 'Практика', 'highlight' => true],

            ['group_id' => 4, 'subject_id' => 9, 'teacher_id' => 8, 'time_id' => 1, 'room_id' => 5, 'date' => '2025-03-11', 'comment' => '', 'highlight' => false],
            ['group_id' => 4, 'subject_id' => 10, 'teacher_id' => 4, 'time_id' => 2, 'room_id' => 4, 'date' => '2025-03-11', 'comment' => '', 'highlight' => false],

            ['group_id' => 4, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-12', 'comment' => 'Контрольная работа', 'highlight' => true],
            ['group_id' => 4, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 4, 'room_id' => 1, 'date' => '2025-03-12', 'comment' => '', 'highlight' => false],

            ['group_id' => 4, 'subject_id' => 7, 'teacher_id' => 5, 'time_id' => 2, 'room_id' => 3, 'date' => '2025-03-13', 'comment' => '', 'highlight' => false],
            ['group_id' => 4, 'subject_id' => 5, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 4, 'date' => '2025-03-13', 'comment' => '', 'highlight' => false],

            ['group_id' => 4, 'subject_id' => 3, 'teacher_id' => 5, 'time_id' => 1, 'room_id' => 3, 'date' => '2025-03-14', 'comment' => 'Лабораторная работа', 'highlight' => true],

            ['group_id' => 4, 'subject_id' => 8, 'teacher_id' => 2, 'time_id' => 1, 'room_id' => 5, 'date' => '2025-03-17', 'comment' => '', 'highlight' => false],
            ['group_id' => 4, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 2, 'room_id' => 1, 'date' => '2025-03-17', 'comment' => 'Разбор задач', 'highlight' => true],
            ['group_id' => 4, 'subject_id' => 4, 'teacher_id' => 8, 'time_id' => 3, 'room_id' => 4, 'date' => '2025-03-17', 'comment' => '', 'highlight' => false],


            // ===== Группа 5 (5-дневка) =====
            ['group_id' => 5, 'subject_id' => 3, 'teacher_id' => 5, 'time_id' => 1, 'room_id' => 3, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],
            ['group_id' => 5, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 2, 'room_id' => 1, 'date' => '2025-03-10', 'comment' => '', 'highlight' => false],
            ['group_id' => 5, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-10', 'comment' => 'Подготовка к лабе', 'highlight' => true],

            ['group_id' => 5, 'subject_id' => 7, 'teacher_id' => 5, 'time_id' => 1, 'room_id' => 3, 'date' => '2025-03-11', 'comment' => '', 'highlight' => false],
            ['group_id' => 5, 'subject_id' => 10, 'teacher_id' => 4, 'time_id' => 2, 'room_id' => 4, 'date' => '2025-03-11', 'comment' => '', 'highlight' => false],

            ['group_id' => 5, 'subject_id' => 4, 'teacher_id' => 8, 'time_id' => 3, 'room_id' => 4, 'date' => '2025-03-12', 'comment' => '', 'highlight' => false],
            ['group_id' => 5, 'subject_id' => 6, 'teacher_id' => 2, 'time_id' => 4, 'room_id' => 2, 'date' => '2025-03-12', 'comment' => 'Практическая работа', 'highlight' => true],

            ['group_id' => 5, 'subject_id' => 1, 'teacher_id' => 2, 'time_id' => 1, 'room_id' => 1, 'date' => '2025-03-13', 'comment' => '', 'highlight' => false],
            ['group_id' => 5, 'subject_id' => 9, 'teacher_id' => 8, 'time_id' => 2, 'room_id' => 5, 'date' => '2025-03-13', 'comment' => '', 'highlight' => false],
            ['group_id' => 5, 'subject_id' => 2, 'teacher_id' => 4, 'time_id' => 3, 'room_id' => 2, 'date' => '2025-03-13', 'comment' => 'Контрольная работа', 'highlight' => true],

            ['group_id' => 5, 'subject_id' => 7, 'teacher_id' => 5, 'time_id' => 1, 'room_id' => 3, 'date' => '2025-03-14', 'comment' => '', 'highlight' => false],
            ['group_id' => 5, 'subject_id' => 10, 'teacher_id' => 4, 'time_id' => 2, 'room_id' => 4, 'date' => '2025-03-14', 'comment' => '', 'highlight' => false],
            ['group_id' => 5, 'subject_id' => 3, 'teacher_id' => 5, 'time_id' => 3, 'room_id' => 3, 'date' => '2025-03-14', 'comment' => 'Лабораторная работа', 'highlight' => true],
        ]);




        DB::table('works')->insert([
            ['theme' => 'Решение квадратных уравнений', 'date' => '2024-02-12', 'type_id' => 1, 'subject_id' => 1],
            ['theme' => 'Контрольная по информатике', 'date' => '2024-03-01', 'type_id' => 2, 'subject_id' => 2],
            ['theme' => 'Лабораторная по базам данных', 'date' => '2024-03-10', 'type_id' => 3, 'subject_id' => 7],
            ['theme' => 'Курсовой проект по Java', 'date' => '2024-04-15', 'type_id' => 4, 'subject_id' => 6],
            ['theme' => 'Практическая по физике', 'date' => '2024-05-10', 'type_id' => 5, 'subject_id' => 3],
            ['theme' => 'Тест по истории', 'date' => '2024-05-20', 'type_id' => 6, 'subject_id' => 4],
            ['theme' => 'Самостоятельная по экономике', 'date' => '2024-05-25', 'type_id' => 7, 'subject_id' => 5],
            ['theme' => 'Экзамен по философии', 'date' => '2024-06-01', 'type_id' => 8, 'subject_id' => 10],
            ['theme' => 'Зачёт по английскому', 'date' => '2024-06-10', 'type_id' => 9, 'subject_id' => 9],
            ['theme' => 'Реферат по математике', 'date' => '2024-06-20', 'type_id' => 10, 'subject_id' => 1],
        ]);

        DB::table('grades')->insert([
            ['user_id' => 7, 'subject_id' => 1, 'work_id' => 1, 'grade' => '5', 'comment' => 'Отличная работа', 'date' => '2025-02-13', 'semester_id' => 2],
            ['user_id' => 8, 'subject_id' => 2, 'work_id' => 2, 'grade' => '4', 'comment' => 'Хорошо, но можно лучше', 'date' => '2025-03-02', 'semester_id' => 2],
            ['user_id' => 9, 'subject_id' => 3, 'work_id' => 3, 'grade' => '5', 'comment' => 'Отличное выполнение лабораторной', 'date' => '2025-03-11', 'semester_id' => 2],
            ['user_id' => 10, 'subject_id' => 4, 'work_id' => 4, 'grade' => '3', 'comment' => 'Сдано с опозданием', 'date' => '2025-04-16', 'semester_id' => 2],
            ['user_id' => 11, 'subject_id' => 5, 'work_id' => 5, 'grade' => '5', 'comment' => 'Отлично', 'date' => '2025-05-11', 'semester_id' => 2],
            ['user_id' => 12, 'subject_id' => 6, 'work_id' => 6, 'grade' => '4', 'comment' => 'Хорошо', 'date' => '2025-05-21', 'semester_id' => 2],
            ['user_id' => 7, 'subject_id' => 7, 'work_id' => 7, 'grade' => '5', 'comment' => 'Отличный результат', 'date' => '2025-06-02', 'semester_id' => 2],
            ['user_id' => 8, 'subject_id' => 8, 'work_id' => 8, 'grade' => '4', 'comment' => 'Хорошо оформлено', 'date' => '2025-06-16', 'semester_id' => 2],
            ['user_id' => 9, 'subject_id' => 9, 'work_id' => 9, 'grade' => '5', 'comment' => 'Прекрасное знание темы', 'date' => '2025-06-21', 'semester_id' => 2],
            ['user_id' => 10, 'subject_id' => 10, 'work_id' => 10, 'grade' => '5', 'comment' => 'Отлично', 'date' => '2025-06-26', 'semester_id' => 2],
            ['user_id' => 9,  'subject_id' => 1, 'work_id' => 1, 'grade' => 5, 'semester_id' => 1, 'date' => '2024-10-05', 'comment' => 'Отличное знание формул'],
            ['user_id' => 10, 'subject_id' => 1, 'work_id' => 2, 'grade' => 4, 'semester_id' => 1, 'date' => '2024-10-05', 'comment' => 'Хорошие результаты'],
            ['user_id' => 11, 'subject_id' => 1, 'work_id' => 3, 'grade' => 3, 'semester_id' => 1, 'date' => '2024-10-05', 'comment' => 'Ошибки в уравнениях'],
            ['user_id' => 9,  'subject_id' => 2, 'work_id' => 4, 'grade' => 4, 'semester_id' => 1, 'date' => '2024-10-10', 'comment' => 'Хорошее понимание алгоритмов'],
            ['user_id' => 10, 'subject_id' => 2, 'work_id' => 5, 'grade' => 5, 'semester_id' => 1, 'date' => '2024-10-10', 'comment' => 'Отлично выполнено'],
            ['user_id' => 11, 'subject_id' => 2, 'work_id' => 6, 'grade' => 3, 'semester_id' => 1, 'date' => '2024-10-10', 'comment' => 'Не все задачи решены'],
            ['user_id' => 12, 'subject_id' => 3, 'work_id' => 7, 'grade' => 4, 'semester_id' => 1, 'date' => '2024-10-15', 'comment' => 'Хорошо, но не идеально'],
            ['user_id' => 13, 'subject_id' => 3, 'work_id' => 8, 'grade' => 5, 'semester_id' => 1, 'date' => '2024-10-15', 'comment' => 'Отличная работа в лаборатории'],
            ['user_id' => 14, 'subject_id' => 3, 'work_id' => 9, 'grade' => 2, 'semester_id' => 1, 'date' => '2024-10-15', 'comment' => 'Не сдана работа'],
            ['user_id' => 15, 'subject_id' => 4, 'work_id' => 10, 'grade' => 4, 'semester_id' => 1, 'date' => '2024-10-20', 'comment' => 'Хорошее знание фактов'],
            ['user_id' => 16, 'subject_id' => 4, 'work_id' => 1, 'grade' => 5, 'semester_id' => 1, 'date' => '2024-10-20', 'comment' => 'Отличное эссе'],
            ['user_id' => 17, 'subject_id' => 4, 'work_id' => 2, 'grade' => 3, 'semester_id' => 1, 'date' => '2024-10-20', 'comment' => 'Нужно больше аргументов'],
            ['user_id' => 9,  'subject_id' => 5, 'work_id' => 3, 'grade' => 4, 'semester_id' => 1, 'date' => '2024-11-01', 'comment' => 'Хорошая теоретическая часть'],
            ['user_id' => 10, 'subject_id' => 5, 'work_id' => 4, 'grade' => 5, 'semester_id' => 1, 'date' => '2024-11-01', 'comment' => 'Отличное выступление'],
            ['user_id' => 11, 'subject_id' => 6, 'work_id' => 5, 'grade' => 3, 'semester_id' => 1, 'date' => '2024-11-07', 'comment' => 'Недостаточно аргументов'],
            ['user_id' => 12, 'subject_id' => 6, 'work_id' => 6, 'grade' => 5, 'semester_id' => 1, 'date' => '2024-11-07', 'comment' => 'Глубокий анализ'],
            ['user_id' => 13, 'subject_id' => 7, 'work_id' => 7, 'grade' => 4, 'semester_id' => 1, 'date' => '2024-11-12', 'comment' => 'Небольшие ошибки в SQL'],
            ['user_id' => 14, 'subject_id' => 7, 'work_id' => 8, 'grade' => 5, 'semester_id' => 1, 'date' => '2024-11-12', 'comment' => 'Идеально выполнено'],
            ['user_id' => 15, 'subject_id' => 8, 'work_id' => 9, 'grade' => 5, 'semester_id' => 1, 'date' => '2024-11-20', 'comment' => 'Превосходная защита проекта'],
            ['user_id' => 16, 'subject_id' => 8, 'work_id' => 10, 'grade' => 4, 'semester_id' => 1, 'date' => '2024-11-20', 'comment' => 'Хороший уровень понимания'],

            // Семестр 2
            ['user_id' => 9,  'subject_id' => 1,  'work_id' => 1, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-03-05', 'comment' => 'Выдающаяся успеваемость'],
            ['user_id' => 10, 'subject_id' => 2,  'work_id' => 2, 'grade' => 4, 'semester_id' => 2, 'date' => '2025-03-05', 'comment' => 'Хорошие навыки программирования'],
            ['user_id' => 11, 'subject_id' => 3,  'work_id' => 3, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-03-10', 'comment' => 'Отличная лабораторная'],
            ['user_id' => 12, 'subject_id' => 4,  'work_id' => 4, 'grade' => 3, 'semester_id' => 2, 'date' => '2025-03-12', 'comment' => 'Поверхностное знание темы'],
            ['user_id' => 13, 'subject_id' => 5,  'work_id' => 5, 'grade' => 4, 'semester_id' => 2, 'date' => '2025-03-14', 'comment' => 'Хороший анализ'],
            ['user_id' => 14, 'subject_id' => 6,  'work_id' => 6, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-03-18', 'comment' => 'Отличный тест'],
            ['user_id' => 15, 'subject_id' => 7,  'work_id' => 7, 'grade' => 4, 'semester_id' => 2, 'date' => '2025-03-19', 'comment' => 'Хорошо структурирован код'],
            ['user_id' => 16, 'subject_id' => 8,  'work_id' => 8, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-03-20', 'comment' => 'Сильный результат'],
            ['user_id' => 17, 'subject_id' => 9,  'work_id' => 9, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-03-25', 'comment' => 'Отличное произношение'],
            ['user_id' => 18, 'subject_id' => 10, 'work_id' => 10, 'grade' => 4, 'semester_id' => 2, 'date' => '2025-03-28', 'comment' => 'Хорошее понимание философии'],
            ['user_id' => 9,  'subject_id' => 1, 'work_id' => 1, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-04-02', 'comment' => 'Стабильно высокий уровень'],
            ['user_id' => 10, 'subject_id' => 2, 'work_id' => 2, 'grade' => 3, 'semester_id' => 2, 'date' => '2025-04-04', 'comment' => 'Пропуск лабораторных'],
            ['user_id' => 11, 'subject_id' => 3, 'work_id' => 3, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-04-08', 'comment' => 'Прекрасная защита работы'],
            ['user_id' => 12, 'subject_id' => 4, 'work_id' => 4, 'grade' => 4, 'semester_id' => 2, 'date' => '2025-04-10', 'comment' => 'Хорошее эссе'],
            ['user_id' => 13, 'subject_id' => 5, 'work_id' => 5, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-04-12', 'comment' => 'Отличная логика изложения'],
            ['user_id' => 14, 'subject_id' => 6, 'work_id' => 6, 'grade' => 3, 'semester_id' => 2, 'date' => '2025-04-15', 'comment' => 'Ошибки в рассуждениях'],
            ['user_id' => 15, 'subject_id' => 7, 'work_id' => 7, 'grade' => 4, 'semester_id' => 2, 'date' => '2025-04-18', 'comment' => 'Хорошая работа над ошибками'],
            ['user_id' => 16, 'subject_id' => 8, 'work_id' => 8, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-04-20', 'comment' => 'Безупречное выступление'],
            ['user_id' => 17, 'subject_id' => 9, 'work_id' => 9, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-04-23', 'comment' => 'Свободно говорит на языке'],
            ['user_id' => 18, 'subject_id' => 10,'work_id' => 10, 'grade' => 4, 'semester_id' => 2, 'date' => '2025-04-25', 'comment' => 'Хорошее эссе'],
            ['user_id' => 9,  'subject_id' => 5, 'work_id' => 1, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-05-05', 'comment' => 'Лучший проект группы'],
            ['user_id' => 10, 'subject_id' => 6, 'work_id' => 2, 'grade' => 4, 'semester_id' => 2, 'date' => '2025-05-06', 'comment' => 'Хорошая структура ответа'],
            ['user_id' => 11, 'subject_id' => 7, 'work_id' => 3, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-05-07', 'comment' => 'Отличный SQL-запрос'],
            ['user_id' => 12, 'subject_id' => 8, 'work_id' => 4, 'grade' => 4, 'semester_id' => 2, 'date' => '2025-05-10', 'comment' => 'Проект завершён вовремя'],
            ['user_id' => 13, 'subject_id' => 9, 'work_id' => 5, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-05-12', 'comment' => 'Хороший результат экзамена'],
            ['user_id' => 14, 'subject_id' => 10,'work_id' => 6, 'grade' => 5, 'semester_id' => 2, 'date' => '2025-05-15', 'comment' => 'Отличное эссе на тему философии'],

        ]);
    }
}
