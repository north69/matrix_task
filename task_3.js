$(function(){
    const api_key = 'a8be06f5ddb842bba8ddabf0bb4c3bcc';
    let changePhone = function (json) {
        let city_name = json.city.name;
        let phone = '8-800-DIGITS';
        switch (city_name) {
            case 'Moscow':
                phone = '+7 (495) DIGITS';
                break;
            case 'Barnaul':
                phone = '+7 (3852) DIGITS';
                break;
            case 'Yekaterinburg':
                phone = '+7 (343) DIGITS';
        }

        document.getElementById('head_phone').textContent = phone;
        document.getElementById('footer_phone').textContent = phone;
        // document.getElementsByClassName('top__contact--phone')[0].textContent = phone; // оставил на память
    }

    fetch('https://api.geoapify.com/v1/ipinfo?apiKey='+api_key, {
        method: 'GET'
    })
        .then(function(response) { return response.json(); })
        .then(changePhone);
});