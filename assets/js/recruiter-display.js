document.getElementById("navbarMyAccount").addEventListener('click', (event) => {
    event.preventDefault();
    console.log('go');
    document.getElementById("navbarMyAccount").classList.add('active');
    document.getElementById("navbarOffers").classList.remove('active');
    document.getElementById("breadcrumbInfo").classList.add('active');
    document.getElementById("breadcrumbSecurity").classList.remove('active');
    document.getElementById("breadcrumbOffers").classList.remove('active');
    document.getElementById("cardInfo").classList.remove('d-none');
    document.getElementById("cardOffers").classList.add('d-none');
    document.getElementById("cardOffers").classList.remove('d-block');
    document.getElementById("cardSecurity").classList.add('d-none');
    document.getElementById("cardSecurity").classList.remove('d-block');
})

document.getElementById("navbarOffers").addEventListener('click', (event) => {
    event.preventDefault();
    document.getElementById("navbarOffers").classList.add('active');
    document.getElementById("navbarMyAccount").classList.remove('active');
    document.getElementById("breadcrumbInfo").classList.remove('active');
    document.getElementById("breadcrumbSecurity").classList.remove('active');
    document.getElementById("breadcrumbOffers").classList.add('active');
    document.getElementById("cardInfo").classList.add('d-none');
    document.getElementById("cardInfo").classList.remove('d-block');
    document.getElementById("cardOffers").classList.add('d-block');
    document.getElementById("cardOffers").classList.remove('d-none');
    document.getElementById("cardSecurity").classList.add('d-none');
    document.getElementById("cardSecurity").classList.remove('d-block');
})

document.getElementById("breadcrumbInfo").addEventListener('click', (event) => {
    event.preventDefault();
    document.getElementById("navbarMyAccount").classList.add('active');
    document.getElementById("navbarOffers").classList.remove('active');
    document.getElementById("breadcrumbInfo").classList.add('active');
    document.getElementById("breadcrumbSecurity").classList.remove('active');
    document.getElementById("breadcrumbOffers").classList.remove('active');
    document.getElementById("cardInfo").classList.add('d-block');
    document.getElementById("cardInfo").classList.remove('d-none');
    document.getElementById("cardOffers").classList.add('d-none');
    document.getElementById("cardOffers").classList.remove('d-block');
    document.getElementById("cardSecurity").classList.add('d-none');
    document.getElementById("cardSecurity").classList.remove('d-block');
})

document.getElementById("breadcrumbSecurity").addEventListener('click', (event) => {
    event.preventDefault();
    document.getElementById("navbarMyAccount").classList.add('active');
    document.getElementById("navbarOffers").classList.remove('active');
    document.getElementById("breadcrumbInfo").classList.remove('active');
    document.getElementById("breadcrumbSecurity").classList.add('active');
    document.getElementById("breadcrumbOffers").classList.remove('active');
    document.getElementById("cardInfo").classList.add('d-none');
    document.getElementById("cardInfo").classList.remove('d-block');
    document.getElementById("cardOffers").classList.add('d-none');
    document.getElementById("cardOffers").classList.remove('d-block');
    document.getElementById("cardSecurity").classList.add('d-block');
    document.getElementById("cardSecurity").classList.remove('d-none');
})

document.getElementById("breadcrumbOffers").addEventListener('click', (event) => {
    event.preventDefault();
    document.getElementById("navbarMyAccount").classList.remove('active');
    document.getElementById("navbarOffers").classList.add('active');
    document.getElementById("breadcrumbInfo").classList.remove('active');
    document.getElementById("breadcrumbSecurity").classList.remove('active');
    document.getElementById("breadcrumbOffers").classList.add('active');
    document.getElementById("cardInfo").classList.add('d-none');
    document.getElementById("cardInfo").classList.remove('d-block');
    document.getElementById("cardOffers").classList.add('d-block');
    document.getElementById("cardOffers").classList.remove('d-none');
    document.getElementById("cardSecurity").classList.add('d-none');
    document.getElementById("cardSecurity").classList.remove('d-block');
})