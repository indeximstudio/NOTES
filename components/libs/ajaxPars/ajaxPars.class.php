<?php

/**
 * ajaxPars.class
 * release 1.1.3
 */
if (!defined('MODX_BASE_PATH')) {
    die('What are you doing? Get out of here!');
}

abstract class ajaxPars
{
    protected $id;
    private $delay;
    private $ajaxPath;
    protected $data;
    public $flow;
    private $start;
    protected $countIterations;

    /**
     * ajaxPars constructor.
     *
     * @param $id - уникальный номер парсинга
     * @param $delay - задержка в мс
     * @param $ajaxPath - ссылка на обработчик
     * @param array $data - данные
     * @param integer $flow - потоки
     */
    function __construct($id, $delay = 1000, $ajaxPath = '', array $data = array(), $flow = 1)
    {
        $this->id = $id;
        $this->delay = $delay;
        $this->ajaxPath = $ajaxPath;
        $this->data = $data;
        $this->flow = $flow;

        $this->get_data_from_session();
        $this->countIterations = $this->getCountIterations();
    }

    /**
     * получение количества итераций
     * @return integer
     */
    abstract function getCountIterations();

    /**
     * выполнение действий С полученными данными
     * @return string
     */
    abstract function getAction();

    /**
     * Сохраняем нужные парамтеры в сессию
     * и обновляем сессию, если данные были переданы
     */
    private function get_data_from_session()
    {
        if (isset($this->data) and count($this->data) != 0) {
            $_SESSION['parsing'][$this->id]['data'] = $this->data;
        } elseif (isset($_SESSION['parsing'][$this->id]['data']) and count($_SESSION['parsing'][$this->id]['data']) > 0) {
            $this->data = $_SESSION['parsing'][$this->id]['data'];
        }

        if (isset($this->flow) and $this->flow != '') {
            $_SESSION['parsing'][$this->id]['flow'] = $this->flow;
        } elseif (isset($_SESSION['parsing'][$this->id]['flow']) and $_SESSION['parsing'][$this->id]['flow'] != '') {
            $this->flow = $_SESSION['parsing'][$this->id]['flow'];
        }
    }

    /**
     * получение процентов выполнения
     * @return integer
     */
    protected function getValue()
    {
        if ($this->countIterations > 0) {
            $_SESSION['parsing'][$this->id]['tekyshiy'] = $_SESSION['parsing'][$this->id]['tekyshiy'] + 1;
            $_SESSION['parsing'][$this->id]['procent'] = $_SESSION['parsing'][$this->id]['tekyshiy'] * 100 / $this->countIterations;
            $value = number_format($_SESSION['parsing'][$this->id]['procent'], 2, '.', '');;
        } else {
            $value = 100;
        }
        return $value;
    }


    /**
     * вычисление и вывод данных о текущей операции
     * @return string
     */
    protected function ajaxTime()
    {
        $time_start = isset($_SESSION['parsing'][$this->id]['start']) ? $_SESSION['parsing'][$this->id]['start'] : 0;
        $ostalos = $this->countIterations - $_SESSION['parsing'][$this->id]['tekyshiy'];

        if ($time_start == 0) {
            $_SESSION['parsing'][$this->id]['time'] = array();
            $ostalos_time_min = '';
        } else {
            if (count($_SESSION['parsing'][$this->id]['time']) > 5) {
                $_SESSION['time'] = array();
            }
            $time_stop = microtime(TRUE);
            $time = $time_stop - $time_start;

            $_SESSION['parsing'][$this->id]['time'][] = $time;
            $sr = 0;
            if (is_array($_SESSION['parsing'][$this->id]['time'])) {
                $sr = array_sum($_SESSION['parsing'][$this->id]['time']) / count($_SESSION['parsing'][$this->id]['time']);
            }

            $ostalos_time = ($ostalos * $sr) / $this->flow;;
            $ostalos_time_min = sprintf('%02d:%02d:%02d', $ostalos_time / 3600, ($ostalos_time % 3600) / 60, ($ostalos_time % 3600) % 60);
        }
        $_SESSION['parsing'][$this->id]['start'] = microtime(true);

        return '<br>processed items = ' . $ostalos . '/' . $this->countIterations . '<br>
                    need time = ' . $ostalos_time_min . ' <br>
                    current = ' . ($_SESSION['parsing'][$this->id]['tekyshiy'] + $this->flow) . ' ';
    }

    /**
     * запуск парсинга
     */
    public function StartPars()
    {
        $this->start = 1;
        $_SESSION['parsing'][$this->id]['tekyshiy'] = 0;
        $_SESSION['parsing'][$this->id]['vsego'] = '';
        $_SESSION['parsing'][$this->id]['start'] = 0;
    }

    /**
     * остановка карсинга
     */
    public function StopPars()
    {
        $this->start = 0;
    }

    /**
     * получаем данные и возвращем их через json
     * @return string
     */
    public function getValueJson()
    {
        $out['text'] = $this->ajaxTime();
        for ($x = 0; $x < $this->flow; $x++) {
            $out['value'] = $this->getValue();
            $out['test'] = $this->getAction();
        }
        return json_encode($out);
    }

    /**
     * вывод полосы прогресса
     * @return string
     */
    public function getProgress()
    {
        $p = '<div class="col-md-6" >
                <div class="form-group" >
                    <label for="categories" > Прогрес</label >
                    <div class="progress" id = "status_bar_item_' . $this->id . '" style = "display:none;" >
                        <div class="progress-bar progress-bar-striped active" role = "progressbar" aria - valuenow = "0" aria - valuemin = "0" aria - valuemax = "100" style = "width:0" ></div >
                    </div >
                </div >
                <br />
                <div id = "statys_' . $this->id . '" ></div >
                <div id = "test_' . $this->id . '" ></div >
              </div >';
        return $p;
    }

    /**
     * перевод данных из пост формы в параметры для отправки по ajax
     * @return string
     */
    private function post_to_value()
    {
        $li = array();
        if (isset($_POST) and count($_POST) > 0) {
            foreach ($_POST as $key => $value) {
                if ($value != '' and $key != '') {
                    $li[] = $key . ":'" . $value . "'";
                }
            }
        }
        $out = implode(",", $li);
        return $out;
    }

    /**
     * @return string
     */
    public function getScript()
    {
        if ($this->start == 1) {
            $start = ' doAjax();';
        } else {
            $start = '';
        }


        $js = "
        <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js'></script>
        <script type='text/javascript'>
            $(function () {
                " . $start . "
                function doAjax() {
                    setTimeout(function () {
                        var url = '" . $this->ajaxPath . "';
                        var data = {" . $this->post_to_value() . "};
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function (sample) {
                    console.log(sample);
                    
                           try {
                                var obj = jQuery.parseJSON(sample);
                                $('#statys_" . $this->id . "').html(obj.text);
                                $('#test_" . $this->id . "').html(obj.test);
                                if (obj.value >= 100) {
                                    obj.value = 100;
                                }
                                $('#status_bar_item_" . $this->id . "').show();
                                $('#status_bar_item_" . $this->id . " .progress-bar').attr('aria-valuenow', obj.value + '%');
                                $('#status_bar_item_" . $this->id . " .progress-bar').width(obj.value + '%');
                                $('#status_bar_item_" . $this->id . " .progress-bar').html(obj.value + '%');
    
                                console.log('load " . $this->id . " ' + obj.value + '%');
                                if (obj.value >= 100) {
                                    obj.value = 100;
                                    $('#status_bar_item_" . $this->id . " .progress-bar').removeClass('progress-bar-striped active');
                                }
                                else {
                                    doAjax();
                                }
                             } catch (err) {
                                doAjax();
                            }
                        },
                    error: function (sample) {
                            console.log('error " . $this->id . " '.sample);
                            doAjax();
                        }
                });
            }, " . $this->delay . ");
                }
            });
</script>";
        return $js;
    }
}