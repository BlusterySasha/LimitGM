<?php
namespace BlusterySasha\LimitGM;

use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\Player;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\block\Block;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerGameModeChangeEvent;
use BlusterySasha\LimitGM\Commands\CommandLimitgm;

class Main extends PluginBase implements Listener{

	public function onPlace(BlockPlaceEvent $event){
        $player = $event->getPlayer();
        $blocks = $event->getBlock()->getId();
        $blacklist = [Block::ENCHANTMENT_TABLE, Block::ANVIL, Block::ITEM_FRAME_BLOCK, Block::SHULKER_BOX, Block::TNT, Block::DIAMOND_BLOCK, Block::IRON_BLOCK, Block::LAPIS_BLOCK, Block::EMERALD_BLOCK, Block::COAL_BLOCK, Block::UNDYED_SHULKER_BOX, Block::DIAMOND_ORE, Block::QUARTZ_ORE, Block::EMERALD_ORE, Block::COAL_ORE, Block::REDSTONE_ORE, Block::LAPIS_ORE, Block::IRON_ORE, Block::GOLD_ORE, Block::GOLD_BLOCK, Block::OBSIDIAN, Block::BEDROCK, Block::END_PORTAL_FRAME, Block::PISTON, Block::STICKY_PISTON];
        if ($player->isCreative()){
            if (in_array($blocks, $blacklist)){
				$player->sendTip("§l§7You cannot put this block in creative.");
				$player->addTitle("§e§lProtected§7!", " ");
                $event->setCancelled();
                $pk = new PlaySoundPacket();
                $pk->x = $player->getX();
                $pk->y = $player->getY();
                $pk->z = $player->getZ();
                $pk->volume = 1;
                $pk->pitch = 1;
                $pk->soundName = 'cauldron.explode';
                $player->dataPacket($pk);
                return;
            }
        }
    }

    public function onPlayerGameModeChange(PlayerGameModeChangeEvent $event){
        $player = $event->getPlayer();
        $newGM = $event->getNewGamemode();
        if ($newGM === 0){
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
	        $player->sendTip("§l§7Предметы очищены.");
			$player->addTitle("§e§lЗищищено§7!", " ");
			$pk = new PlaySoundPacket();
            $pk->x = $player->getX();
            $pk->y = $player->getY();
            $pk->z = $player->getZ();
            $pk->volume = 1;
            $pk->pitch = 1;
            $pk->soundName = 'cauldron.explode';
            $player->dataPacket($pk);
            return;
        }
		if ($newGM === 1){
	        $player->sendTip("§l§7Your items will be cleaned if you switch to creative mode.");
			$player->addTitle("§c§lWarning§7!", " ");
            return;
		}
    }

    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $blocks = $event->getBlock()->getId();
        $blacklist = [Block::ENDER_CHEST, Block::CRAFTING_TABLE, Block::CHEST, Block::FURNACE, Block::BURNING_FURNACE, Block::TRAPPED_CHEST, Block::ENCHANTMENT_TABLE, Block::ANVIL, Block::ITEM_FRAME_BLOCK, Block::SHULKER_BOX, Block::TNT, Block::DROPPER, Block::DISPENSER, Block::UNDYED_SHULKER_BOX];
        if ($player->isCreative()){
            if (in_array($blocks, $blacklist)){
				$player->sendTip("§l§7This block is prohibited in creative mode.");
				$player->addTitle("§e§lProtected§7!", " ");
				$pk = new PlaySoundPacket();
				$pk->x = $player->getX();
				$pk->y = $player->getY();
				$pk->z = $player->getZ();
				$pk->volume = 1;
				$pk->pitch = 1;
				$pk->soundName = 'cauldron.explode';
				$player->dataPacket($pk);
				$event->setCancelled();
                return;
            }
        }
    }

    public function onPlayerDeath(PlayerDeathEvent $event){
        $player = $event->getPlayer();
        if ($player->isCreative()){
            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();
			$player->sendTip("§l§7Your things didn’t fall out, you are in creative mode.");
			$player->addTitle("§e§lProtected§7!", " ");
			$pk = new PlaySoundPacket();
            $pk->x = $player->getX();
            $pk->y = $player->getY();
            $pk->z = $player->getZ();
            $pk->volume = 1;
            $pk->pitch = 1;
            $pk->soundName = 'cauldron.explode';
            $player->dataPacket($pk);
        }
    }

    public function onDropItem(PlayerDropItemEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->isCreative()){
	        $player->sendTip("§l§7Вы не можете выбрасывать вещи в творческом режиме.");
			$player->addTitle("§e§lЗащищено§7!", " ");
			$pk = new PlaySoundPacket();
            $pk->x = $player->getX();
            $pk->y = $player->getY();
            $pk->z = $player->getZ();
            $pk->volume = 1;
            $pk->pitch = 1;
            $pk->soundName = 'cauldron.explode';
            $player->dataPacket($pk);
            $event->setCancelled();
        }
    }

    public function onAttack(EntityDamageEvent $event){
        if ($event instanceof EntityDamageByEntityEvent){
            $player = $event->getDamager();
            if ($player instanceof Player){
                if ($player->isCreative()) {
					$player->sendTip("§l§7You cannot drop items in creative mode.");
					$player->addTitle("§e§lProtected§7!", " ");
					$pk = new PlaySoundPacket();
					$pk->x = $player->getX();
					$pk->y = $player->getY();
					$pk->z = $player->getZ();
					$pk->volume = 1;
					$pk->pitch = 1;
					$pk->soundName = 'cauldron.explode';
					$player->dataPacket($pk);
                    $event->setCancelled();
                }
            }
        }
    }

	private function registerCommands(){
		$this->getServer()->getCommandMap()->register("limitgm", new SoulMine());
	}



}
