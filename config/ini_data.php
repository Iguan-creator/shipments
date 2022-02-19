<?php
/*
 * Main parameters for the shipment types. It works during migration automatically as
 * they are not expected to be changed.
 */
return [
    'parameters' => [
        1 => [
            'table' => 'client',
            'plural_name' => 'Клиенты',
            'singular_name' => 'Клиент',
            'short' => 'Клиент',
            'required' => true,
        ],
        2 => [
            'table' => 'contractors',
            'plural_name' => 'Подрядчики',
            'singular_name' => 'Подрядчик',
            'short' => 'Подр-к',
            'required' => true,
        ],
        3 => [
            'table' => 'car',
            'plural_name' => 'Типы машин',
            'singular_name' => 'Тип машины',
            'short' => 'Тип машины',
            'required' => true,
        ],
        4 => [
            'table' => 'delivery_condition',
            'plural_name' => 'Условия поставки',
            'singular_name' => 'Условие поставки',
            'short' => 'Усл. пост-ки',
            'required' => true,
        ],
        5 => [
            'table' => 'container',
            'plural_name' => 'Типы контейнеров',
            'singular_name' => 'Тип контейнера',
            'short' => 'Тип конт-ра',
            'required' => true,
        ],
        6 => [
            'table' => 'ports',
            'plural_name' => 'Порты',
            'singular_name' => 'Порт',
            'short' => 'Порт',
            'required' => true,
        ],
        7 => [
            'table' => 'airports',
            'plural_name' => 'Аэропорты',
            'singular_name' => 'Аэропорт',
            'short' => 'Аэропорт',
            'required' => true,
        ],
        8 => [
            'table' => 'stations',
            'plural_name' => 'Станции',
            'singular_name' => 'Станция',
            'short' => 'Ст-ия',
            'required' => true,
        ],
        9 => [
            'table' => 'load_place',
            'plural_name' => 'Места загрузки',
            'singular_name' => 'Место загрузки',
            'short' => 'Место загр-ки',
            'required' => true,
        ],
        10 => [
            'table' => 'delivery_place',
            'plural_name' => 'Места доставки',
            'singular_name' => 'Место доставки',
            'short' => 'Место дост-ки',
            'required' => true,
        ],
        11 => [
            'table' => 'position_number',
            'plural_name' => 'Номера позиционников',
            'singular_name' => '№ позиционника',
            'short' => '№ позиц-ка',
            'required' => true,
        ],
        12 => [
            'table' => 'batch_weight',
            'plural_name' => 'Веса партий',
            'singular_name' => 'Вес партии',
            'short' => 'Вес',
            'required' => false,
        ],
        13 => [
            'table' => 'batch_size',
            'plural_name' => 'Объёмы партий',
            'singular_name' => 'Объём партии',
            'short' => 'Объём',
            'required' => false,
        ],
        14 => [
            'table' => 'spot_quantity',
            'plural_name' => 'Количества мест',
            'singular_name' => 'Количество мест',
            'short' => 'Кол-во мест',
            'required' => false,
        ],
        15 => [
            'table' => 'm_a_w_b_number',
            'plural_name' => 'Номера MAWB',
            'singular_name' => '№ MAWB',
            'short' => '№ MAWB',
            'required' => false,
        ],
        16 => [
            'table' => 'h_a_w_b_number',
            'plural_name' => 'Номера HAWB',
            'singular_name' => '№ HAWB',
            'short' => '№ HAWB',
            'required' => false,
        ],
        17 => [
            'table' => 'transport_doc_number',
            'plural_name' => 'Номера транспортных документов',
            'singular_name' => '№ Транспортного документа',
            'short' => '№ транс. док.',
            'required' => false,
        ],
        18 => [
            'table' => 'container_number',
            'plural_name' => 'Номера контейнеров',
            'singular_name' => '№ контейнера',
            'short' => '№ конт-ра',
            'required' => false,
        ],
        19 => [
            'table' => 'carriage_number',
            'plural_name' => 'Номера вагона',
            'singular_name' => '№ вагона',
            'short' => '№ вагона',
            'required' => false,
        ],
        20 => [
            'table' => 'comment',
            'plural_name' => 'Комментарии',
            'singular_name' => 'Комментарий',
            'short' => 'Коммент.',
            'required' => false,
        ],
        21 => [
            'table' => 'load_date',
            'plural_name' => 'Даты затарки',
            'singular_name' => 'Дата затарки',
            'short' => 'Дата затарки',
            'required' => true,
        ],
        22 => [
            'table' => 'send_planned_date',
            'plural_name' => 'Даты отправки (план)',
            'singular_name' => 'Дата отправки (план)',
            'short' => 'Дата отпр. (план)',
            'required' => true,
        ],
        23 => [
            'table' => 'send_actual_date',
            'plural_name' => 'Даты отправки (факт)',
            'singular_name' => 'Дата отправки (факт)',
            'short' => 'Дата отпр. (факт)',
            'required' => false,
        ],
        24 => [
            'table' => 'arrival_plan_date',
            'plural_name' => 'Даты прибытия (план)',
            'singular_name' => 'Дата прибытия (план)',
            'short' => 'Дата приб. (план)',
            'required' => true,
        ],
        25 => [
            'table' => 'arrival_actual_date',
            'plural_name' => 'Даты прибытия (факт)',
            'singular_name' => 'Дата прибытия (факт)',
            'short' => 'Дата приб. (факт)',
            'required' => false,
        ],
        26 => [
            'table' => 'delivery_end_date',
            'plural_name' => 'Даты закрытия доставки',
            'singular_name' => 'Дата закрытия доставки',
            'short' => 'Дата закр. дост.',
            'required' => false,
        ],
        27 => [
            'table' => 'release_date',
            'plural_name' => 'Даты выпуска',
            'singular_name' => 'Дата выпуска',
            'short' => 'Дата вып-ка',
            'required' => false,
        ],
        28 => [
            'table' => 'delivery_actual_date',
            'plural_name' => 'Даты доставки (факт)',
            'singular_name' => 'Дата доставки (факт)',
            'short' => 'Дата дост. (факт)',
            'required' => false,
        ],
        29 => [
            'table' => 'send_station_date',
            'plural_name' => 'Даты отправки (станция)',
            'singular_name' => 'Дата отправки (станция)',
            'short' => 'Дата отпр. (станц)',
            'required' => false,
        ],
        30 => [
            'table' => 'arrival_station_date',
            'plural_name' => 'Даты прибытия (станция)',
            'singular_name' => 'Дата прибытия (станция)',
            'short' => 'Дата приб. (станц)',
            'required' => false,
        ],
        31 => [
            'table' => 'seller',
            'plural_name' => 'Продавцы',
            'singular_name' => 'Продавец',
            'short' => 'Продавец',
            'required' => false,
        ],
        32 => [
            'table' => 'sender',
            'plural_name' => 'Отправители',
            'singular_name' => 'Отправитель',
            'short' => 'Отпр-ль',
            'required' => false,
        ],
        33 => [
            'table' => 'receiver',
            'plural_name' => 'Получатели',
            'singular_name' => 'Получатель',
            'short' => 'Пол-ль',
            'required' => false,
        ],
        34 => [
            'table' => 'booking_number',
            'plural_name' => 'Номера букинга',
            'singular_name' => 'Номера букинга',
            'short' => 'Ном. бук.',
            'required' => false,
        ],
        35 => [
            'table' => 'arrival_port_date',
            'plural_name' => 'Дата Порт прибытия ПЛАН',
            'singular_name' => 'Дата Порт прибытия ПЛАН',
            'short' => 'Дата Порт приб. (план)',
            'required' => false,
        ],
    ],

    'types' => [
        1 => 'Море',
        2 => 'Море-ЖД',
        3 => 'Море-ЖД-Сборка',
        4 => 'Море-Сборка',
        5 => 'Авиа',
        6 => 'Авиа-Сборка',
        7 => 'ЖД-Сборка',
        8 => 'ЖД',
        9 => 'ЖД-РФ',
        10 => 'ЖД-РФ-Сборка',
        11 => 'Авто',
    ],

    'parameter_type' => [
        1 => [11, 1, 2, 4, 5, 17, 18, 6, 9, 10, 21, 22, 23, 24, 25, 26, 27, 28, 32, 33, 20],
        2 => [11, 1, 2, 4, 5, 17, 18, 6, 8, 10, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 32, 33, 20, 35],
        3 => [11, 1, 2, 4, 12, 13, 17, 18, 6, 10, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 32, 33, 20, 35],
        4 => [11, 1, 2, 4, 12, 13, 17, 18, 6, 9, 10, 21, 22, 23, 24, 25, 26, 27, 28, 32, 33, 20],
        5 => [11, 1, 2, 4, 12, 13, 15, 16, 7, 9, 10, 21, 22, 23, 24, 25, 26, 27, 28, 32, 33, 20],
        6 => [11, 1, 2, 4, 12, 13, 15, 16, 7, 9, 10, 21, 22, 23, 24, 25, 26, 27, 28, 32, 33, 20],
        7 => [11, 1, 2, 4, 12, 13, 18, 8, 9, 10, 21, 22, 23, 24, 25, 26, 27, 28, 32, 33, 20, 34],
        8 => [11, 1, 2, 4, 5, 18, 8, 9, 10, 21, 22, 23, 24, 25, 26, 27, 28, 32, 33, 20],
        9 => [11, 1, 2, 5, 14, 12, 18, 19, 8, 9, 10, 21, 22, 23, 24, 25, 26, 27, 28, 32, 33, 20],
        10 => [11, 1, 2, 13, 12, 18, 8, 9, 10, 21, 22, 23, 24, 25, 26, 27, 28, 32, 33, 20],
        11 => [11, 1, 2, 3, 5, 18, 9, 10, 21, 22, 23, 24, 25, 26, 27, 28, 32, 33, 20],
    ],

    'lists' => [
        [
            'name' => 'Клиенты',
            'link' => 'clients'
        ],
        [
            'name' => 'Продавцы',
            'link' => 'sellers'
        ],
        [
            'name' => 'Подрядчики',
            'link' => 'contractors'
        ],
        [
            'name' => 'Типы машин',
            'link' => 'cars'
        ],
        [
            'name' => 'Условия поставки',
            'link' => 'delivery_conditions'
        ],
        [
            'name' => 'Типы контейнеров',
            'link' => 'containers'
        ],
        [
            'name' => 'Порты',
            'link' => 'ports'
        ],
        [
            'name' => 'Аэропорты',
            'link' => 'airports'
        ],
        [
            'name' => 'Станции',
            'link' => 'stations'
        ],
        [
            'name' => 'Места загрузки',
            'link' => 'load_places'
        ],
        [
            'name' => 'Места доставки',
            'link' => 'delivery_places'
        ],
        [
            'name' => 'Отправители',
            'link' => 'senders'
        ],
        [
            'name' => 'Получатели',
            'link' => 'receivers'
        ],
    ]

];
