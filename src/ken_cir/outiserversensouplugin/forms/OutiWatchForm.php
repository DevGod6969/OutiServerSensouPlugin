<?php

declare(strict_types=1);

namespace ken_cir\outiserversensouplugin\forms;

use Error;
use Exception;
use ken_cir\outiserversensouplugin\cache\playercache\PlayerCacheManager;
use ken_cir\outiserversensouplugin\EventListener;
use ken_cir\outiserversensouplugin\forms\admin\AdminForm;
use ken_cir\outiserversensouplugin\forms\faction\FactionForm;
use ken_cir\outiserversensouplugin\forms\mail\MailForm;
use ken_cir\outiserversensouplugin\Main;
use pocketmine\player\Player;
use pocketmine\Server;
use Vecnavium\FormsUI\SimpleForm;
use function strtolower;

/**
 * おうちウォッチ
 */
final class OutiWatchForm
{
    public function __construct()
    {
    }

    /**
     * @param Player $player
     * フォーム実行
     */
    public function execute(Player $player): void
    {
        try {
            $form = new SimpleForm(function (Player $player, $data) {
                try {
                    PlayerCacheManager::getInstance()->get($player->getName())->setLockOutiWatch(false);

                    if ($data === null) return true;
                    elseif ($data === 1) {
                        $form = new FactionForm();
                        $form->execute($player);
                    }
                    elseif ($data === 2) {
                        $form = new MailForm();
                        $form->execute($player);
                    }
                    elseif ($data === 3) {
                        $form = new ReportForm();
                        $form->execute($player);
                    }
                    elseif ($data === 4) {
                        $form = new RequestForm();
                        $form->execute($player);
                    }
                    elseif ($data === 5 and Server::getInstance()->isOp($player->getName())) {
                        $form = new AdminForm();
                        $form->execute($player);
                    }
                } catch (Error | Exception $e) {
                    Main::getInstance()->getOutiServerLogger()->error($e, $player);
                }

                return true;
            });

            $form->setTitle("おうちウォッチ");
            $form->addButton("§c閉じる");
            $form->addButton("§d派閥");
            $form->addButton("§eメール");
            $form->addButton("§4レポート");
            $form->addButton("§6要望");
            if (Server::getInstance()->isOp($player->getName())) {
                $form->addButton("管理者");
            }
            $form->addButton("テスト", 0, "textures/items/facebook");
            $player->sendForm($form);
        }
        catch (Error|Exception $e) {
            Main::getInstance()->getOutiServerLogger()->error($e, true, $player);
        }
    }
}