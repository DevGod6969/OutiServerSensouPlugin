<?php

declare(strict_types=1);

namespace Ken_Cir\OutiServerSensouPlugin\Forms\Faction;

use Error;
use Exception;
use Ken_Cir\OutiServerSensouPlugin\Main;
use Ken_Cir\OutiServerSensouPlugin\Managers\FactionData\FactionDataManager;
use Ken_Cir\OutiServerSensouPlugin\Managers\PlayerData\PlayerDataManager;
use pocketmine\player\Player;
use Vecnavium\FormsUI\CustomForm;

/**
 * 派閥作成フォーム
 */
class CreateFactionForm
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
            var_dump($player->getName());
            $player_data = PlayerDataManager::getInstance()->get($player->getName());
            // 既に派閥所属済みの場合は
            if ($player_data->getFaction() !== -1) {
                $player->sendMessage("§cあなたは既に派閥 {$player_data->getFaction()} に所属しています");
                return;
            }

            $form = new CustomForm(function (Player $player, $data) use ($player_data) {
                try {
                    if ($data === null) return true;
                    elseif (!isset($data[0]) or !isset($data[1])) return true;
                    $id = FactionDataManager::getInstance()->create($data[0], $player->getName(), (int)$data[1]);
                    $player_data->setFaction($id);
                    $player->sendMessage("§a[システム]派閥 $data[0] を作成しました\n派閥の詳細は /factioninfo で確認できます");
                } catch (Error | Exception $e) {
                    Main::getInstance()->getPluginLogger()->error($e);
                }

                return true;
            });

            $form->setTitle("§d派閥作成フォーム");
            $form->addInput("§a派閥名§c", "name");
            $form->addDropdown("§e派閥チャットカラー", ["黒", "濃い青", "濃い緑", "濃い水色", "濃い赤色", "濃い紫", "金色", "灰色", "濃い灰色", "青", "緑", "水色", "赤", "ピンク", "黄色", "白色"]);
            $player->sendForm($form);
        } catch (Error | Exception $error) {
            Main::getInstance()->getPluginLogger()->error($error);
        }
    }
}