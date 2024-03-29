const menu = Array.from(document.querySelectorAll('.mobileMenu'));
const menuChildren = Array.from(document.querySelectorAll('.mobileMenu>*'));

const openMenu = () => {
    menu.forEach(((item) => {
        item.style.transform = 'scaleX(1)';
    }));
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
        menu.forEach(((item) => {
            item.style.transform = 'scaleX(0)';
        }));
    }, 200);
}

const isElementInArray = (el, arr) => {
    return arr.findIndex((item) => {
        return item === el;
    }) !== -1;
}

const allPosts = Array.from(document.querySelectorAll(`.blog__articles__item`));
const allPostsCategories = Array.from(document.querySelectorAll(`.blog__articles__item>.blog__articles__item__category`));
const allCategoriesButtons = Array.from(document.querySelectorAll('.blog__categories__btn'));

const filterCategories = (cat, all = false) => {
    if(all) {
        allPosts.forEach((item, index) => {
            if(index <= 5) {
				item.style.display = 'block';
			}
			else {
				item.classList.add('hidden');
				item.classList.add('h-0');
			}
        });
    }
    else {
		console.log(allPosts);
        const numOfPosts = allPosts.map((item, index) => {
            item.style.opacity = '0';
			item.classList.remove('hidden');
			item.classList.remove('h-0');
			
            const postCategories = allPostsCategories[index].getAttribute('id').split(';').map((item) => {
                return convertToURL(item);
            });
			console.log(postCategories);
            setTimeout(() => {
                item.style.opacity = '1';
            }, 300);
            if(isElementInArray(convertToURL(cat), postCategories)) {
                item.style.display = 'block';
                return 1;
            }
            else {
                item.style.display = 'none';
                return 0;
            }
        });
			
        if(numOfPosts.findIndex((item) => { return item === 1; }) === -1) {

        }
    }
}

Array.from(document.querySelectorAll('.blog__categories__btn')).forEach((item) => {
    item.addEventListener('click', (e) => {
        const id = e.target.attributes.id.nodeValue.trim();

        allCategoriesButtons.forEach((item, index, arr) => {
            if(index !== arr.length-1 && index !== 0) {
                item.style.fontWeight = '400';
            }
        });
        e.target.style.fontWeight = '700';

        if(id !== 'all') filterCategories(id);
        else filterCategories(null, true);
    });
});

const catParam = new URLSearchParams(window.location.search).get('kategoria');

const convertToURL = (str) => {
    if(str) return str.toLowerCase()
        .replace(/ /g, "-")
        .replace(/ą/g, "a")
        .replace(/ć/g, "c")
        .replace(/ę/g, "e")
        .replace(/ł/g, "l")
        .replace(/ń/g, "n")
        .replace(/ó/g, "o")
        .replace(/ś/g, "s")
        .replace(/ź/g, "z")
        .replace(/ż/g, "z")
    else return "";
}

if(catParam) {
    const buttonToColor = allCategoriesButtons.findIndex((item) => {
        return convertToURL(item.getAttribute('id').split(';')[0]) === catParam;
    });
    allCategoriesButtons.forEach((item, index, arr) => {
        if(index !== arr.length-1 && index !== 0) {
            item.style.fontWeight = '400';
        }
    });
    if(buttonToColor !== -1) allCategoriesButtons[buttonToColor].style.fontWeight = '700';

    filterCategories(catParam);
}