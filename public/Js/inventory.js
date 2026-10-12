document.addEventListener('mousemove', function (e) {
    const tooltips = document.querySelectorAll('.tooltip');

    tooltips.forEach(tooltip => {
        if (window.getComputedStyle(tooltip).visibility === 'visible') {
            let x = e.clientX + 5;
            let y = e.clientY + 5;

            const tooltipWidth = tooltip.offsetWidth;
            const tooltipHeight = tooltip.offsetHeight;

            if (x + tooltipWidth > window.innerWidth) {
                x = e.clientX - tooltipWidth - 5;
            }

            if (y + tooltipHeight > window.innerHeight) {
                y = e.clientY - tooltipHeight - 5;
            }

            tooltip.style.left = x + 'px';
            tooltip.style.top = y + 'px';
        }
    })
});


function equipItem(slotIndex) {
    fetch(`equip?slot=${slotIndex}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('player-inventory').innerHTML = data.inventoryHtml;
                document.getElementById('equipment').innerHTML = data.equipmentHtml;
                document.getElementById('player-health').innerText = data.health;
                document.getElementById('stat-Vitality').innerText = data.totalVit;
                document.getElementById('stat-Strength').innerText = data.totalStr;
                document.getElementById('stat-Energy').innerText = data.totalEng;
                document.getElementById('char-window-player-damage').innerText = data.damage;
                refreshStatUI('Strength', data.baseStr, data.totalStr);
                refreshStatUI('Vitality', data.baseVit, data.totalVit);
                refreshStatUI('Energy', data.baseEng, data.totalEng);
                console.log("Item equipped");
            }
        })
        .catch(error => console.error('Error equipping item:', error));
}

function unequipItem(slotName) {
    fetch(`unequip?slot=${slotName}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('player-inventory').innerHTML = data.inventoryHtml;
                document.getElementById('equipment').innerHTML = data.equipmentHtml;
                document.getElementById('stat-Vitality').innerText = data.totalVit;
                document.getElementById('stat-Strength').innerText = data.totalStr;
                document.getElementById('stat-Energy').innerText = data.totalEng;
                document.getElementById('player-health').innerText = data.health;
                document.getElementById('char-window-player-damage').innerText = data.damage;
                refreshStatUI('Strength', data.baseStr, data.totalStr);
                refreshStatUI('Vitality', data.baseVit, data.totalVit);
                refreshStatUI('Energy', data.baseEng, data.totalEng);

                console.log(data);
                console.log(slotName + " unequipped");
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error unequipping item:', error));
}
