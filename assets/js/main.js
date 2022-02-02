const menu = document.querySelector('.mobileMenu');
const menuChildren = Array.from(document.querySelectorAll('.mobileMenu>*'));

const openMenu = () => {
    menu.style.transform = 'scaleX(1)';
    setTimeout(() => {
        menuChildren.forEach((item) => {
           item.style.opacity = '1';
        });
    }, 200);
}

const closeMenu = () => {
    menuChildren.forEach((item) => {
        item.style.opacity = '0';
    });
    setTimeout(() => {
        menu.style.transform = 'scaleX(0)';
    }, 200);
}
