CREATE OR REPLACE FUNCTION random_first_name() RETURNS text AS $$
DECLARE
    names text[] := ARRAY['Григорий', 'Лев', 'Андрей', 'Роман', 'Арсений', 'Степан',
        'Владислав','Никита','Глеб','Дмитрий','Марк','Давид','Ярослав', 'Евгений', 'Матвей',
        'Фёдор','Николай','Андрей','Артемий','Никита','Даниил','Денис', 'Егор', 'Игорь',
        'Лев','Леонид','Павел','Петр','Роман','Руслан','Сергей', 'Семён', 'Тимофей',
        'Константин','Юрий'];
BEGIN
    RETURN names[floor(random()*35 + 1)::int];
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_last_name() RETURNS text AS $$
DECLARE
    names text[] := ARRAY['Авдюшин', 'Воробьев', 'Борисов', 'Ильин', 'Медведев', 'Матвеев',
        'Власов','Афанасьев','Чернов','Назаров','Сазонов','Родионов','Воронин', 'Пономарев', 'Потапов',
        'Краснов','Овчинников','Трофимов','Леонов','Соболев','Ермаков', 'Колесников', 'Гончаров',
        'Журавлев','Тихомиров','Скворцов','Симонов','Прокофьев','Харитонов', 'Князев', 'Цветков',
        'Горбунов','Галкин','Юдин','Леонов','Соболев','Ермаков', 'Колесников', 'Майоров',
        'Анисимов','Лукьянов','Белоусов','Нестеров','Левин','Митрофанов', 'Воронов', 'Аксенов',
        'Еремин','Михеев','Трофимов','Савин','Софронов','Мальцев', 'Логинов', 'Горшков',
        'Емельянов','Никифоров','Грачев','Котов','Гришин','Ефремов', 'Архипов', 'Громов',
        'Кириллов','Малышев','Панов','Моисеев','Румянцев','Акимов', 'Кондратьев', 'Бирюков'];
BEGIN
    RETURN names[floor(random()*71 + 1)::int];
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION patronymic() RETURNS text AS $$
DECLARE
    names text[] := ARRAY['Анисимович', 'Ильмирович', 'Захарович', 'Кириллович', 'Константинович', 'Леонтьевич',
        'Леонович','Макарович','Наумович','Николаевич','Олегович','Платонович','Романович', 'Рустамович', 'Семёнович',
        'Тарасович','Теймуразович','Фёдорович','Феофанович','Емельянович','Ерофеевич','Демидович', 'Дмитриевич', 'Давидович',
        'Германович','Генрихович','Гаврилович','Вячеславович','Глебович','Демидович','Вениаминович', 'Борисыч', 'Батькович',
        'Артёмович','Андреевич'];
BEGIN
    RETURN names[floor(random()*35 + 1)::int];
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_full_name() RETURNS text AS $$
BEGIN
    RETURN random_first_name() || ' ' || patronymic() || ' ' || random_last_name();
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_email() RETURNS text AS $$
BEGIN
    RETURN random_first_name() || random_last_name() || floor(random()*1000 + 1)::text || '@example.com';
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_phone_number() RETURNS bigint AS $$
BEGIN
    RETURN '89' || floor(random()*900000000 + 100000000)::bigint;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION random_sentence() RETURNS text AS $$
DECLARE
    sentences text[] := ARRAY[
        'Это тестовое предложение.',
        'Вот ещё одно примерное предложение.',
        'Ещё одно случайное предложение для тестирования.',
        'Ловкий бурый лис перепрыгнул через ленивую собаку.',
        'Ранняя пташка ловит червя каждое утро.',
        'Практика делает мастера для начинающих художников.',
        'Время и приливы никого не ждут.',
        'Застежка вовремя сэкономит девять.',
        'Удача сопутствует смелым в начинаниях.',
        'Молчание - золото, когда нужна осмотрительность.',
        'Знание - сила в современном мире.',
        'Быть или не быть, вот в чём вопрос.',
        'Я мыслю, значит, я существую.',
        'Не всё золото, что блестит.',
        'Одинаковые люди тянутся друг к другу.',
        'Дела говорят громче слов.',
        'Сбережённая копейка - заработанная копейка.',
        'Две ошибки не исправляют правильное решение.',
        'Когда в Риме, поступай как римляне.',
        'Перо могущественнее меча.',
        'Никто не является островом.',
        'Трава всегда зеленее по ту сторону забора.',
        'Картина рисует тысячу слов визуально.',
        'Когда дела идут тяжело, сильные берутся за дело.',
        'Красота в глазах смотрящего.',
        'Необходимость - мать изобретений.',
        'Смотрящий на чайник никогда не закипает.',
        'Нищим не приходится выбирать.',
        'Чистота - залог благочестия.',
        'Птица в руках стоит двух в кустах.'
        ];
BEGIN
    RETURN sentences[floor(random()*30 + 1)::int];
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE PROCEDURE Multiply(count int)
    LANGUAGE plpgsql
AS $$
DECLARE
    i int := 0;
BEGIN
    WHILE i < count LOOP
            INSERT INTO suggestions (date, created_at, author, collaborator, email, phone_number, depart_id, type_id, suggestion_content, economic_indic_id, sent_for_expertise, manager_comment, does_solve_a_problem, realizer, status_id)
            VALUES (
                           CURRENT_DATE,
                           CURRENT_DATE, -- Y-M-D format
                           random_full_name(),
                           random_full_name(),
                           random_email(),
                           random_phone_number(),
                           1,
                           1,
                           random_sentence(),
                           null,
                           false,
                           null,
                           false,
                           null,
                           1
                   );
            i := i + 1;
        END LOOP;
END;
$$;


