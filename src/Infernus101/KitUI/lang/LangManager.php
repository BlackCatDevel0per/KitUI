<?php

namespace Infernus101\KitUI\lang;

use Infernus101\KitUI\Main;
use pocketmine\utils\Config;

class LangManager{

    const LANG_VERSION = 0;

    private $pl;
    private $defaults;
    private $data;

    public function __construct(Main $pl){
        $this->pl = $pl;
        $this->defaults = [
            "lang-version" => 0,
			"error-title" => "Ошибка:",
			"mainmenu-title" => "Кит наборы",
			"mainmenu-content" => "Выберите набор:",
			"select-option" => "Подтверждение выбора:",
            "selected-kit" => "Выбранный набор: {%0}",
            "inv-full" => "В вашем инвентаре недостаточно места для этого комплекта",
            "cant-afford" => "Вы не можете позволить себе комплект: {%0} Цена: {%1}",
            "one-per-life" => "Вы можете получить только один комплект за всю жизнь",
            "no-sign-perm" => "У вас нет разрешения на редактирование кти наборов",
            "timer1" => "Кит сейчас недоступен {%0}",
            "timer2" => "Вы сможете получить его в {%0}",
            "noperm" => "У вас нет разрешения на использование комплекта {%0} {%0}",
            "timer-format1" => "{%0} минут",
            "timer-format2" => "{%0} часов и {%1} минут",
            "timer-format3" => "{%0} часов",
        ];
        $this->data = new Config($this->pl->getDataFolder()."lang.properties", Config::PROPERTIES, $this->defaults);
        if($this->data->get("lang-version") != self::LANG_VERSION){
            $this->pl->getLogger()->alert("Translation file is outdated. The old file has been renamed and a new one has been created");
            @rename($this->pl->getDataFolder()."lang.properties", $this->pl->getDataFolder()."lang.properties.old");
            $this->data = new Config($this->pl->getDataFolder()."lang.properties", Config::PROPERTIES, $this->defaults);
        }
    }

    public function getTranslation(string $dataKey, ...$args) : string{
        if(!isset($this->defaults[$dataKey])){
            $this->pl->getLogger()->error("Invalid datakey $dataKey passed to method LangManager::getTranslation()");
            return "";
        }
        $str = $this->data->get($dataKey, $this->defaults[$dataKey]);
        foreach($args as $key => $arg){
            $str = str_replace("{%".$key."}", $arg, $str);
        }
        return $str;
    }

}
