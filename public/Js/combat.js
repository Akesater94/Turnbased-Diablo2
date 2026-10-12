function toggleDisplayStyle(element) {
    if (element.style.display === "none") {
        element.style.display = "flex";
    }
    else {
        element.style.display = "none";
    }
}

function showIncreaseStats(){
    let statIncreaseButtons = document.getElementsByClassName('add-stats');
    
    for(const statIncreaseButton of statIncreaseButtons)
    {
        statIncreaseButton.style.display = "table-cell";
    }
}


function toggleCharWindow(){
    let charWindow = document.getElementById('character-window-container');
    toggleDisplayStyle(charWindow);
}

function toggleInventory() {
    let inventoryAndEquipment = document.getElementById('inventory-and-equipment');
    toggleDisplayStyle(inventoryAndEquipment);
}

document.addEventListener('keydown', function (event) {

    let charWindow = document.getElementById('character-window-container');

    if (event.key === "i" || event.key === "I") {
        event.preventDefault();
        toggleInventory();
    }
    if (event.key === "c" || event.key === "C") {
        event.preventDefault();
        toggleCharWindow();
    }
    if (event.code === "Space") {
        startAutoAttack();
        
    }
});

let playerAttackInterval = null;
let monsterAttackInterval = null;


function startAutoAttack() {
    startMonsterAttack();
    
    const playerAttackSpeed = 1200;
    if (playerAttackInterval) clearInterval(playerAttackInterval);
    
    playerAttackInterval = setInterval(() => {
        performAttack();
    }, playerAttackSpeed);
}

function startMonsterAttack(){
    const monsterAttackSpeed = 600;
    if (monsterAttackInterval) clearInterval(monsterAttackInterval);
    monsterAttackInterval = setInterval(() => {
        monsterPerformAttack();
    },monsterAttackSpeed);
    
}



StrikeSounds = [
    new Audio('Assets/sounds/blade1.wav'),
    new Audio('Assets/sounds/blade2.wav'),
    new Audio('Assets/sounds/blade3.wav'),
    new Audio('Assets/sounds/blade4.wav'),
    new Audio('Assets/sounds/blade5.wav'),
    new Audio('Assets/sounds/blade6.wav'),
]

function monsterPerformAttack(){
    fetch('monsterStrike')
        .then(response => response.json())
        .then(data => {
            if(data.success){
                updateCombatUI(data);
                console.log("monster hits player!", data.health);
            }
        })
}

function usePotion(){
    fetch('heal')
        .then(response => response.json())
        .then(data => {
            if(data.success){
                updateCombatUI(data);
                console.log("player healed for: ", data.health);
            }
        })
}


function performAttack() {
    fetch('strike')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                playHitSound(StrikeSounds);
                updateCombatUI(data);
                console.log("Player hits monster!");

                if (data.monsterDead) {
                    lootItem();
                    handleMonsterDeath();
                    
                    if(data.leveledUp){
                        document.getElementById('player-level').innerText = data.newLevel;
                        document.getElementById('unspent-points').innerText = data.unspentPoints;
                        console.log(data);
                        showIncreaseStats();
                    }
                }
            }
    });
}

function lootItem(){
    fetch('loot')
    .then(response => response.json())
    .then(data => {
        if(data.success){
            document.getElementById('player-inventory').innerHTML = data.PlayerInventoryHtml;
        }
    })
}

function updateCombatUI(data) {
    const monsterHpPercent = (data.monsterhealth / data.monstermaxhealth) * 100;
    document.getElementById('hp-bar-inner').style.width = monsterHpPercent + "%";

    const playerHpPercent = (data.health / data.maxHealth) * 100;
    document.getElementById('inner-health-orb').style.height = playerHpPercent + "%";
    document.getElementById('inner-health-orb').style.zIndex = 1;

    document.getElementById('player-health').innerText = data.health + "/" + data.maxHealth;

    const expPercent = (data.currentExp / data.maxExp) * 100;
    document.getElementById('exp-bar').style.width = expPercent + "%";
    document.getElementById('exp-bar-text').innerText = Math.floor(expPercent) + "%";
}

function handleMonsterDeath() {
    playDeathSound();
    clearInterval(playerAttackInterval);
    clearInterval(monsterAttackInterval);
    setTimeout(() => {
        fetch('spawnNewEnemy')
            .then(response => response.json())
            .then(newMonster => {
                document.getElementById('monster-name').innerText = newMonster.monsterName;
                document.getElementById('monster-image').src = newMonster.monsterImage;
                document.getElementById('hp-bar-inner').style.width = "100%";
                startAutoAttack();
            });
    }, 1000);
}

function playHitSound(array) {
    const randomIndex = Math.floor(Math.random() * array.length);
    var audio = array[randomIndex];
    audio.play();
}

function playDeathSound() {
    var audio = new Audio('Assets/sounds/death1.wav');
    audio.play();
}





