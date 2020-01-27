<?php
namespace BlusterySasha\LimitGM\Commands;

use BlusterySasha\LimitGM\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class CommandLimitgm extends Command{
	public function __construct(){
		parent::__construct("limitgm", "", null);
		}
		
		public function execute(CommandSender $sender, $label, array $args){
			if($sender instanceof Player){
				$player = $sender;
				$player->sendMessage("§6Плагин работает, всё хорошо!");
				$player->addTitle("§2Скоро будут новые функции, смотрите консоль.");
				}else{
					$sender->sendMessage("§cОшибка, не изменяйте плагин.");
				}
		}
}