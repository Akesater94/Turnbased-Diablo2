

function purchaseItem(slotIndex){
    fetch(`buyItem?slot=${slotIndex}`)
        .then(response => response.json())
        .then(data => {
            if(data.success){
                document.getElementById('merchant-inventory').innerHTML = data.MerchantInventoryHtml;
                document.getElementById('player-inventory').innerHTML = data.PlayerInventoryHtml
                console.log("Item purchased");
            } else {
                console.log("player inventory is full!");
            }
        })
        .catch(error => console.error('Error purchasing item:', error));
}

function sellItem(slotIndex){
    fetch(`sellItem?slot=${slotIndex}`)
    .then(response => response.json())
    .then(data => {
        if(data.success){
            document.getElementById('player-inventory').innerHTML = data.PlayerInventoryHtml;
            document.getElementById('merchant-inventory').innerHTML = data.MerchantInventoryHtml;
            console.log("Item sold!");
        }
    })
    .catch(error => console.error('Error purchasing item:', error));
}