
function toggleDisplayStyle(element) {
    if (element.style.display === "none") {
        element.style.display = "flex";
    }
    else {
        element.style.display = "none";
    }
}

function toggleCharWindow() {
    let charWindow = document.getElementById('character-window-container');
    toggleDisplayStyle(charWindow);
}

function toggleInventory() {
    let inventoryAndEquipment = document.getElementById('inventory-and-equipment');
    toggleDisplayStyle(inventoryAndEquipment);
}

function toggleWaypoint(){
    let areasWindow = document.getElementsByClassName('areas-table')[0];
    toggleDisplayStyle(areasWindow);
}

let waypointButton = document.getElementsByClassName('waypoint-button')[0];
waypointButton.addEventListener('click', (e) => {
    e.preventDefault();
    toggleWaypoint();
})

let inventoryButton = document.getElementsByClassName('inventory-button')[0];
inventoryButton.addEventListener('click', (e) => {
    e.preventDefault();
    toggleInventory();
})

document.addEventListener('keydown', function (event) {

    if (event.key === "i" || event.key === "I") {
        event.preventDefault();
        toggleInventory();
    }
    if (event.key === "c" || event.key === "C") {
        event.preventDefault();
        toggleCharWindow();
    }
});

function refreshStatUI(statId, base, total) {
    const element = document.getElementById('stat-' + statId);
    if (!element) return;

    element.innerText = total;

    if (total > base) {
        element.style.color = "#4850b8";
    } else {
        element.style.color = "#999";
    }
}