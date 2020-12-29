let mobileMenuButton = document.getElementsByName('mobile-menu-button');
let mobileIsOpen = false;
mobileMenuButton[0].addEventListener("click", ()=> {
    if(mobileIsOpen) {
        mobileMenuButton[0].classList.remove('mobile-button-pressed');
        mobileIsOpen = false;
        triggerMobileMenu(mobileIsOpen);                

    }else {
        mobileMenuButton[0].classList.add('mobile-button-pressed');
        mobileIsOpen = true;
        triggerMobileMenu(mobileIsOpen);
    }
});

let mobileLangButton = document.getElementsByName('mobile-lang-button');
let mobileLangOpen = false;
if(mobileLangButton[0]){
    mobileLangButton[0].addEventListener("click", ()=> {
        if(mobileLangOpen) {
            mobileLangButton[0].classList.remove('mobile-lang-pressed');
            mobileLangOpen = false;
            triggerLangSwitch(mobileLangOpen);                
        }else {
            mobileLangButton[0].classList.add('mobile-lang-pressed');
            mobileLangOpen = true;        
            triggerLangSwitch(mobileLangOpen);        
        }
    });
    
}


appendDropdownButton();


function triggerLangSwitch(langButtonState) {
    let mobileLangContainer = document.getElementById('nextt-lang-switch');
    if(langButtonState) {
        mobileLangContainer.classList.add('mobile-lang-pressed');
    }else{
        mobileLangContainer.classList.remove('mobile-lang-pressed');
    }
}

function triggerMobileMenu(mobileMenuState) {
    let mobileMenuContainer = document.getElementById('nextt-mobile-menu');
    if(mobileMenuState) {
        mobileMenuContainer.classList.add('mobile-menu-pressed');
    }else{
        mobileMenuContainer.classList.remove('mobile-menu-pressed');
    }
}

function appendDropdownButton() {
    let mobileMenuContainer = document.getElementById('nextt-mobile-menu');
    let dropdownMenus = mobileMenuContainer.getElementsByClassName('menu-item-has-children');
    [...dropdownMenus].forEach(dropdownMenu => {
        dropdownMenu.insertBefore(createDropdownButton(), dropdownMenu.firstChild);
    });
}

function createDropdownButton(){
    let newSpanElement = document.createElement('span');
    newSpanElement.classList.add('has-children-span');
    addDropdownButtonFunctionality(newSpanElement);
    return newSpanElement;
}

function addDropdownButtonFunctionality(element) {
    element.addEventListener("click", () => {
        if (!element.classList.contains('dropdown-is-open')) {
            element.classList.add("dropdown-is-open");
        }else {
            element.classList.remove("dropdown-is-open");
        }
    });
}
