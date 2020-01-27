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
				$player->sendMessage("§6The plugin works, everything is fine! More features coming soon, expect new updates.");
				$player->addTitle("§2I'm working.");
				}else{
					$sender->sendMessage("§cThis command works only from the player.");
				}
		}
}
