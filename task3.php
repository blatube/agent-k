<?php
/** КОД-РЕВЬЮ
 * Приведёт фрагмент кода классов мероприятий и событий.
 * Событие - это каое-либо публичное действие (спектакль, киносеанс, и т.п.), у каждого события есть своя собственная ссылка на сайте, список секторов (партер, балкон) и цена.
 * Мероприятие - аггрегирующая сощность для несольких событий. Например, балет Лебединое озеро может идти целый месяц, но каждое конкретное представление - отедльное событие.
 *
 * Пожалуйста, проверите код-ревью приведённого фрагмента.
 * Пишите свои комментарии справа, либо сверху от фрагмента, который хотите прокомментировать.
 * Укажите почему фрагмент написал плохо(или хорошо), как можно улучшить решение.
 *
 * Class Action
 */

class Action
{
    // Вынести в константу
    public static function getServiceFeeRate()
    {
        return 0.01;
    }

    /**
     * Исходя из имнеи метода, ожидаю получить строку, получаю массив
     * Если переименовать в getUrlChunks/Parts будет более читабельно
     */
    public function getUrl() {
        return ['example.com', 'action', 'novogodnyaya_elka', '#' => 'description'];
    }
}

class Event extends Action
{
    // Порядок объявления: public, protected, private; static имеет более высокий приоритет
    private $id;
    private $price;
    // Сделать приватным
    public $sectors;


    public function getUrl()
    {
        $urlParts = ['id' => $this->id];
        // Если только так используем родительский метод, то лучше его вынести из функции
        $urlParts = parent::getUrl() + $urlParts;
        /**
         * Думаю от этого стоит избавиться
         * https://sun9-11.userapi.com/impf/c628030/v628030366/ff6b/9z9DxeOnxok.jpg?size=604x433&quality=96&proxy=1&sign=900b21fe1f602aaa1671298bbc7879a8
         */
        if (isset($urlParts['#']))  {
            $sharp = $urlParts['#'];
            unset($urlParts['#']);
            $urlParts['#'] = $sharp;
        }

        return $urlParts;
    }

    // Перенести после объявления полей
    public function __construct(int $id, float $price)
    {
        $this->id = $id;
        $this->price = $price;
    }

    // Страдает семантика. Если пишем фильтр, то должны вернуть копию
    public static function filterActiveSectors(&$sectors)
    {
        foreach ($sectors as $key => &$sector) {
            /**
             *  приходит массив, а не объект
             *  использовать полный синтаксис if (...) {..}
            */
            if (!$sector->active)
                unset($sectors[$key]);
        }
    }

    public function getSectors()
    {
        return $this->sectors;
    }

    public function setSectors(array $sectors)
    {
        $this->sectors = $sectors;
    }

    public function getTotal()
    {
        return $this->price * Action::getServiceFeeRate() + $this->price;
    }
}

$event = new Event(1, 100.18);
// Ошибка в составлении массва
$event->setSectors([1 => ['name' => 'Партер', 'quantity' => 200, 'active' => true], [2 => ['name' => 'Балкон', 'quantity' => 100, , 'active' => false]]]);
// $event->getSectors() назначить переменной
$sectors = Event::filterActiveSectors($event->getSectors());

var_dump($sectors);
echo (int) $event->getTotal();
echo implode('/', $event->getUrl());