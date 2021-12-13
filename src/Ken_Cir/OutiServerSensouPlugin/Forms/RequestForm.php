<?php

declare(strict_types=1);

namespace Ken_Cir\OutiServerSensouPlugin\Forms;

use Error;
use Exception;
use Ken_Cir\OutiServerSensouPlugin\Main;
use Ken_Cir\OutiServerSensouPlugin\Utils\OutiServerPluginUtils;
use pocketmine\player\Player;
use Vecnavium\FormsUI\CustomForm;

/**
 * 要望フォーム
 */
class RequestForm
{
    public function __construct()
    {
    }

    /**
     * @param Player $player
     * フォーム実行
     */
    public function execute(Player $player)
    {
        try {
            $form = new CustomForm(function (Player $player, $data) {
                try {
                    if ($data === null) return true;
                    elseif (!isset($data[0])) return true;
                    OutiServerPluginUtils::sendDiscordLog(Main::getInstance()->getPluginConfig()->get("Report_Request_Webhook", ""), "**要望**\n{$player->getName()} からの要望\n$data[0]");
                    $player->sendMessage("§a[システム] 要望を送信しました");
                }
                catch (Error | Exception $e) {
                    Main::getInstance()->getPluginLogger()->error($e, $player);
                }

                return true;
            });

            $form->setTitle("要望フォーム");
            $form->addInput("§d内容", "content");
            $form->addLabel("§e要望内容に対する返信は内部メールで行います");
            $player->sendForm($form);
        }
        catch (Error | Exception $error) {
            Main::getInstance()->getPluginLogger()->error($error, $player);
        }
    }
}