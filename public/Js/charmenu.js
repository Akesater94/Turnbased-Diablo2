document.querySelectorAll('.add-point-btn').forEach(button => {
    button.addEventListener('click', function () {
        const statName = this.getAttribute('data-stat');
        const formData = new FormData();
        formData.append('stat', statName);

        fetch('addPoints', {
            method: 'POST',
            body: formData  
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const statButtons = document.querySelectorAll('.add-stats');
                    statButtons.forEach(el => el.style.display = 'table-cell');

                    document.getElementById('unspent-points').innerText = data.unspentPoints;
                    document.getElementById('char-window-player-damage').innerText = data.damage;
                    document.getElementById('player-health').innerText = data.health + "/" + data.maxHealth;
                    document.getElementById('stat-Vitality').innerText = data.totalVit;
                    document.getElementById('stat-Strength').innerText = data.totalStr;
                    document.getElementById('stat-Energy').innerText = data.totalEng;
                    refreshStatUI('Strength', data.baseStr, data.totalStr);
                    refreshStatUI('Vitality', data.baseVit, data.totalVit);
                    refreshStatUI('Energy', data.baseEng, data.totalEng);
                    console.log(data);

                    if (data.unspentPoints === 0) {
                        statButtons.forEach(el => el.style.display = 'none');
                    } else {

                    }

                } else {
                    alert(data.message);
                }
            });
    });

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