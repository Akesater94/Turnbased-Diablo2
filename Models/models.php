<?php
class Stats
{

    function __construct(public int $Strength, public int $Energy, public int $Vitality, public int $UnspentPoints) {}
}

class Character
{

    function __construct(public string $name, public int $health, public int $damage) {}

    public function recieveDamage(int $amount)
    {
        $this->health = max(0, $this->health - $amount);
    }

    public function isDead(): bool
    {
        return $this->health <= 0;
    }
}

class heroClass
{
    function __construct(
        public string $name,
        public string $imgSource,
        public string $imgSourceSelect,
        public int $startingStrength,
        public int $startingVitality,
        public int $startingEnergy,
    ) {}
}

class Player extends Character
{
    public string $className;
    public Stats $charStats;
    public SplFixedArray $Inventory;
    public PlayerItems $EquippedItems;
    public int $level;
    public int $maxHealth;
    public int $currentExp;
    public int $maxExp;
    public int $damage;
    public int $leftoverExp = 0;
    public int $totalStr;
    public int $totalVit;
    public int $totalEng;
    public heroClass $Class;
    function __construct(
        string $name,
        int $health,
        int $damage,
        int $level,
        int $currentExp,
        int $maxExp,
        ?PlayerItems $EquippedItems,
        heroClass $Class
    ) {
        $this->className = $Class->name;
        $this->Class = $Class;
        $this->EquippedItems = $EquippedItems;
        $this->Inventory = new SplFixedArray(12);
        $this->damage = $damage;
        $this->level = $level;
        $this->maxHealth = $health;
        $this->currentExp = $currentExp;
        $this->maxExp = $maxExp;
        $this->charStats =  new Stats($Class->startingStrength, $Class->startingEnergy, $Class->startingVitality, 0);
        parent::__construct($name, $health, $damage);
    }

    public function addItemToInventory(Item $Item): bool
    {
        foreach ($this->Inventory as $Index => $Slot) {
            if ($Slot === null) {
                $this->Inventory[$Index] = $Item;
                return true;
            }
        }

        return false;
    }

    public function usePotion(int $amount){
        if(($this->health + $amount) >= $this->maxHealth){
            $this->health = $this->maxHealth;
            return;
        }

        $this->health += $amount;
    }

    public static function playerFactory($jsonString, $HeroClasses)
    {
        $data = json_decode($jsonString, true);

        $classKey = $data['className'] ?? 'Barbarian';

        $player = new self(
            $data['name'],
            $data['health'],
            $data['damage'],
            $data['level'],
            $data['currentExp'],
            $data['maxExp'],
            new PlayerItems(),
            $HeroClasses[$classKey]
        );

        $player->charStats = new Stats(
            $data['charStats']['Strength'],
            $data['charStats']['Energy'],
            $data['charStats']['Vitality'],
            $data['charStats']['UnspentPoints']
        );

        if (isset($data['Inventory']) && is_array($data['Inventory'])) {
            foreach ($data['Inventory'] as $index => $itemData) {
                if ($itemData !== null) {
                    $player->Inventory[$index] = new Item(
                        ItemEnum::from($itemData['typeOfItem']),
                        $itemData['name'],
                        $itemData['damage'],
                        $itemData['aSpeed'] ?? 0,
                        $itemData['bonusHealth'] ?? 0,
                        $itemData['bonusEnergy'] ?? 0,
                        $itemData['bonusVitality'] ?? 0,
                        $itemData['bonusStrength'] ?? 0,
                        $itemData['imageSource'] ?? ""
                    );
                }
            }
        }
        if (isset($data['EquippedItems'])) {
            foreach (['Helm', 'Body', 'MainHand'] as $slot) {
                if (!empty($data['EquippedItems'][$slot])) {
                    $eData = $data['EquippedItems'][$slot];
                    $player->EquippedItems->$slot = new Item(
                        ItemEnum::from($eData['typeOfItem']),
                        $eData['name'],
                        $eData['damage'] ?? 0,
                        $eData['aSpeed'] ?? 0,
                        $eData['bonusHealth'] ?? 0,
                        $eData['bonusEnergy'] ?? 0,
                        $eData['bonusVitality'] ?? 0,
                        $eData['bonusStrength'] ?? 0,
                        $eData['imageSource'] ?? ""
                    );
                }
            }
        }

        $player->updateStats();
        return $player;
    }

    public function gainExp(int $amount): bool
    {
        $this->currentExp += $amount;

        if ($this->currentExp >= $this->maxExp) {
            $this->leftoverExp =  $this->currentExp - $this->maxExp;
            $this->levelUp();
            return true;
        }
        return false;
    }

    public function clearInventory()
    {

        foreach ($this->Inventory as $Index => $slot) {
            $this->Inventory[$Index] = null;
        }
    }

    public function spendStatPoint(string $statName): bool
    {
        if ($this->charStats->UnspentPoints <= 0) {
            return false;
        }

        switch ($statName) {
            case 'Strength':
                $this->charStats->Strength++;
                break;
            case 'Vitality':
                $this->charStats->Vitality++;
                break;
            case 'Energy':
                $this->charStats->Energy++;
                break;
            default:
                return false;
        }

        $this->charStats->UnspentPoints--;
        $this->updateStats();

        return true;
    }

    public function updateStats()
    {
        $baseStrength = $this->charStats->Strength;
        $baseVitality = $this->charStats->Vitality;
        $baseEnergy = $this->charStats->Energy;

        $bonusStr = 0;
        $bonusVit = 0;
        $bonusEng = 0;
        $itemDamage = 0;
        $bonusHealth = 0;

        foreach (['Helm', 'Body', 'MainHand'] as $slot) {
            $item = $this->EquippedItems->$slot;

            if ($item !== null) {
                $bonusStr += (int)$item->bonusStrength;
                $bonusVit += (int)$item->bonusVitality;
                $bonusEng += (int)$item->bonusEnergy;
                $itemDamage += (int)$item->damage;
                $bonusHealth += (int)$item->bonusHealth;
            }
        }

        $this->totalStr = $baseStrength + $bonusStr;
        $this->totalVit = $baseVitality + $bonusVit;
        $this->totalEng = $baseEnergy + $bonusEng;

        $this->damage = (int)(($this->totalStr * 0.5) + $itemDamage);
        $this->maxHealth = (int)(($this->totalVit * 4) + $bonusHealth);
    }

    private function levelUp()
    {
        $this->level++;
        $this->charStats->UnspentPoints += 5;
        $this->currentExp = $this->leftoverExp;
        $this->maxExp = (int)($this->maxExp * 1.5);

        $this->leftoverExp = 0;
    }

    public function hasInventorySpace(): bool
    {
        foreach ($this->Inventory as $slot) {

            if ($slot === null) {
                return true;
            }
        }

        return false;
    }

    public function equipItem(int $inventoryIndex): bool
    {
        if (!isset($this->Inventory[$inventoryIndex]) || $this->Inventory[$inventoryIndex] === null) {
            return false;
        }

        $itemToEquip = $this->Inventory[$inventoryIndex];
        $slotName = $itemToEquip->typeOfItem->value;

        $oldItem = $this->EquippedItems->$slotName;
        $this->EquippedItems->$slotName = $itemToEquip;
        $this->Inventory[$inventoryIndex] = $oldItem;

        $this->updateStats();

        return true;
    }

    public function unequipItem(string $slotName): bool
    {

        if (!isset($this->EquippedItems->$slotName) || $this->EquippedItems->$slotName === null) {
            return false;
        }

        if (!$this->hasInventorySpace()) {
            return false;
        }

        $item = $this->EquippedItems->$slotName;
        $this->addItemToInventory($item);
        $this->EquippedItems->$slotName = null;

        $this->updateStats();

        return true;
    }

    public function getPublicState(bool $leveledUp = false): array
    {
        return [
            'success' => true,
            'leveledUp' => $leveledUp,
            'newLevel' => $this->level,
            'currentExp' => $this->currentExp,
            'maxExp' => $this->maxExp,
            'health' => $this->health,
            'damage' => $this->damage,
            'unspentPoints' => $this->charStats->UnspentPoints,
            'totalStr' => $this->totalStr,
            'maxHealth' => $this->maxHealth,
            'totalVit' => $this->totalVit,
            'totalEng' => $this->totalEng,
            'baseStr'  => $this->charStats->Strength,
            'baseVit'  => $this->charStats->Vitality,
            'baseEng'  => $this->charStats->Energy
        ];
    }
}

class Merchant
{
    public SplFixedArray $inventory;
    function __construct()
    {
        $this->inventory = new SplFixedArray(18);
    }

    public function generateInventory(array $items)
    {

        foreach ($this->inventory as $Index => $slot) {
            if ($slot === null) {
                $RandomKey = array_rand($items);
                $this->inventory[$Index] = $items[$RandomKey];
            } else {
                $this->inventory[$Index] === null;
            }
        }
    }

    public function sellItemToPlayer($merchantInventoryIndex): bool
    {
        $Player = $_SESSION['player'];

        if (!isset($this->inventory[$merchantInventoryIndex]) || $this->inventory[$merchantInventoryIndex] === null) {
            return false;
        }

        $itemToSell = $this->inventory[$merchantInventoryIndex];

        if ($Player->addItemToInventory($itemToSell)) {
            $this->inventory[$merchantInventoryIndex] = null;
            return true;
        } else {
            return false;
        }
    }

    public function addItemToInventory(Item $Item)
    {
        foreach ($this->inventory as $Index => $Slot) {
            if ($Slot === null) {
                $this->inventory[$Index] = $Item;
                return;
            }
        }
    }

    public function buyItemFromPlayer($PlayerInventoryIndex)
    {
        $Player = $_SESSION['player'];
        $itemToBuy = $Player->Inventory[$PlayerInventoryIndex];

        foreach ($this->inventory as $index => $slot) {
            if (!is_null($slot)) {
                $this->addItemToInventory($itemToBuy);
                $Player->Inventory[$PlayerInventoryIndex] = null;
                return true;
            }
        }
    }
}

class Monster extends Character
{
    public int $expReward;
    public string $imageSource;
    public int $maxHealth;
    public array $LootTable = [];
    function __construct(string $name, int $health, int $damage, int $expReward, string $imageSource)
    {
        $this->expReward = $expReward;
        $this->imageSource = $imageSource;
        $this->maxHealth = $health;
        parent::__construct($name, $health, $damage);
    }

    public static function createMonsterFromSession(array $session): Monster
    {
        return new self(
            $session['monster-name'],
            $session['monster-current-health'],
            $session['monster-damage'],
            $session['exp-reward'],
            $session['monster-image'],
        );
    }

    public function dropItem($dropChance): ?Item
    {

        if (rand(0, 100) >= $dropChance) {
            $itemKey = array_rand($this->LootTable);
            return $this->LootTable[$itemKey];
        } else {
            return null;
        }
    }

    public function getPublicState(): array
    {
        return [
            'monsterName' => $this->name,
            'monsterhealth' => $this->health,
            'monstermaxhealth' => $this->maxHealth,
            'monsterImage' => $this->imageSource,
            'isDead' => $this->isDead()
        ];
    }

    public function syncToSession(array &$session)
    {
        $session['monster-health'] = $this->health;
    }
}

class Area
{
    function __construct(
        public string $name,
        public int $level,
        public array $monsters,
        public array $items
    ) {
        foreach ($this->items as $item) {
            $item->origin = $this->name;
        }

        foreach ($this->monsters as $monster) {
            $monster->LootTable = $this->items;
        }
    }
}

enum ItemEnum: string
{
    case Helm = 'Helm';
    case Body = 'Body';
    case MainHand = 'MainHand';
}

class Item
{
    public int $ItemLevel;
    public ?string $origin = null;

    function __construct(
        public ItemEnum $typeOfItem,
        public string $name = "",
        public int $damage = 0,
        public int $aSpeed = 0,
        public int $bonusHealth = 0,
        public int $bonusEnergy = 0,
        public int $bonusVitality = 0,
        public int $bonusStrength = 0,
        public string $imageSource = "",
        public ?string $areaName = null,
    ) {
        $this->origin = $areaName;
    }
}

class PlayerItems
{
    function __construct(
        public ?Item $Helm = null,
        public ?Item $Body = null,
        public ?Item $MainHand = null,
    ) {}
}
