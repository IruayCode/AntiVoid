<?php

namespace Iruay\AntiVoid;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\player\Player;
use pocketmine\world\Position;
use pocketmine\Server;

class AntiVoidPlugin extends PluginBase implements Listener {

    // change coordinates
    private const TELEPORT_X = 1;
    private const TELEPORT_Y = 65;
    private const TELEPORT_Z = 0;
    private const TELEPORT_WORLD = "world";

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§aAntiVoid On!");
    }

    /**
     *
     *
     * @param PlayerMoveEvent $event
     */
    public function onPlayerMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();

        if ($player->getPosition()->getY() < 0) {
            $this->teleportToSafeZone($player);
        }
    }

    /**
     *
     *
     * @param Player $player
     */
    private function teleportToSafeZone(Player $player): void {
        $world = $this->getServer()->getWorldManager()->getWorldByName("world"); // change your world!

        if ($world === null) {
            $player->sendMessage("§cError : Can't find world teleportation");
            return;
        }

        $safePosition = new Position(
            self::TELEPORT_X,
            self::TELEPORT_Y,
            self::TELEPORT_Z,
            $world
        );

        $player->sendMessage("§6Teleport to safe zone!");
        $player->teleport($safePosition);
    }
}
