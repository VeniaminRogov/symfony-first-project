console.log('add_phone_client');

const form = document.querySelector('form');
const sort = document.querySelector('#search_form_sort');

console.log(sort);

const pageInput = document.querySelector('#search_form_page');

document.querySelectorAll('a.page-link').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        pageInput.value = e.target.getAttribute('href').split('').pop();
        form.submit();
    });
});

const addPhoneFormDeleteLink = item => {
    const removeFormButton = document.createElement('button');
    removeFormButton.innerHTML = 'Delete phone';

    item.appendChild(removeFormButton);

    removeFormButton.addEventListener('click', e => {
        e.preventDefault();

        item.remove();
    })
}


const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
    const item = document.createElement('li');
    item.innerHTML = collectionHolder.dataset.prototype.replace(/__name__/g, collectionHolder.dataset.index);
    collectionHolder.appendChild(item);
    collectionHolder.dataset.index++;

    addPhoneFormDeleteLink(item);
}

document.querySelectorAll('.add_item_link').forEach(btn => {
    btn.addEventListener('click', addFormToCollection);
});



document.querySelectorAll('ul.phones li').forEach(phone => {
    addPhoneFormDeleteLink(phone)
})

