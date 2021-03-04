require('./bootstrap');
require('./nav');
require('./noise');

let notifications = document.querySelectorAll("[data-hide]")
notifications.forEach(notification => {
    notification.addEventListener('click',
        () => {
            document.querySelector(notification.getAttribute('data-hide')).classList.add('hidden')
        })
})


document.addEventListener('download', () =>
    document.querySelector('#download-notification').classList.remove('hidden'))


let downloadLinks = document.querySelectorAll("a[download]:not([data-external])")
downloadLinks.forEach(downloadLink => {
    downloadLink.addEventListener('click', () => document.dispatchEvent(new Event('download')))
})

let dropdowns = document.querySelectorAll("[data-dropdown]")
dropdowns.forEach(dropdown => {
    let trigger = document.querySelector(dropdown.getAttribute('data-dropdown'));
    trigger.addEventListener('click', () => {
        if (dropdown.classList.contains('hidden'))
            dropdown.classList.remove('hidden')
        else
            dropdown.classList.add('hidden')
    })
})

let endTrials = document.querySelectorAll("[data-request-end-trial]")
endTrials.forEach(el => {
    el.addEventListener('click', function () {
        Swal.fire({
            template: '#my-template'
        }).then(result => {
            if (result.isConfirmed) {
                axios.post(el.getAttribute('data-request-url'))
                    .then(result => location.reload())
            }
        })
    })
})
