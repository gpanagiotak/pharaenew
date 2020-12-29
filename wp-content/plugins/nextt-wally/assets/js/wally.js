/**
 * -> Created by christospapidas on 260615--.
 */
var WGallery;
(function (WGallery) {
    var Define = (function () {
        function Define() {
            Define.popupHtml = '<div class="wally-popup" id="' + Define.popupId + '"> <div class="wally-image-content" id="' + Define.popupContent + '"> </div> <div class="wally-menu"> <button id="' + Define.popupPrev + '" class="wally-button"> </button> <button id="' + Define.popupNext + '" class="wally-button"> </button> <div class="wally-hr"></div> <button id="' + Define.popupCloseId + '" class="wally-button"> X </button> </div> <div class="wally-label"> <span class="wally-label-text" id="' + Define.currentImageIndex + '"></span> <span class="wally-label-text">/</span> <span class="wally-label-text" id="' + Define.imagesLength + '"></span> <span class="wally-label-text wally-label-text-space" id="' + Define.imageTitle + '"></span> </div> </div>';
        }
        Define.popupImg = function (imagePath) {
            return '<img id=""src="' + imagePath + '" align="middle">';
        };
        Define.wally = 'wally';
        Define.categoryIdentifier = 'wally-category';
        Define.imageIdPref = 'wally_image_';
        Define.imageIdNumbPref = 'image';
        Define.buttonCoverImage = 'wallycover';
        Define.imagePathAttr = 'src';
        Define.imageTitleAttr = 'title';
        Define.categoryIdentifierIdAttr = 'arrayid';
        Define.popupId = 'wally-popup';
        Define.popupCloseId = 'wally-popup-close';
        Define.popupNext = 'wally-next';
        Define.popupPrev = 'wally-prev';
        Define.popupHtml = '';
        Define.popupContent = 'wally-content';
        Define.currentImageIndex = 'current-image-index';
        Define.imagesLength = 'image-length';
        Define.imageTitle = 'image-title';
        Define.buttonDisplayGalleryAttr = 'display';
        Define.displayTypeBlock = 'block';
        Define.displayTypeCategories = 'categories';
        return Define;
    })();
    WGallery.Define = Define;
})(WGallery || (WGallery = {}));
/**
 * Created by christospapidas on 260615--.
 */
var WGallery;
(function (WGallery) {
    var Tools = (function () {
        function Tools() {
        }
        /**
         * Return the element by id
         * @param id
         * @returns {HTMLElement}
         */
        Tools.prototype.el = function (id) {
            return document.getElementById(id);
        };
        /**
         * Return the attribute
         * @param id
         * @param name
         * @returns {string}
         */
        Tools.prototype.attr = function (id, name) {
            return document.getElementById(id).getAttribute(name);
        };
        /**
         *
         * @param htmlElement
         * @param name
         * @returns {string}
         */
        Tools.prototype.attrE = function (htmlElement, name) {
            return htmlElement.getAttribute(name);
        };
        /**
         * Add Style to HTML Ellement
         * @param id
         * @param styleType
         * @param value
         */
        Tools.prototype.addStyle = function (id, styleType, value) {
            document.getElementById(id).style[styleType] = value;
            return;
        };
        /**
         * Get Ellement by class name
         * @param className
         * @returns {NodeList}
         */
        Tools.prototype.byClass = function (className) {
            return document.getElementsByClassName(className);
        };
        return Tools;
    })();
    WGallery.Tools = Tools;
})(WGallery || (WGallery = {}));
/**
 * Created by christospapidas on 070715--.
 */
/// <reference path="IImageData.ts"/>
/// <reference path="Tools.ts"/>
/// <reference path="Define.ts"/>
var WGallery;
(function (WGallery) {
    var Thumbs = (function () {
        function Thumbs(imageData) {
            this.t = new WGallery.Tools();
            this.imageData = imageData;
            this.action();
        }
        Thumbs.prototype.action = function () {
            // For each category name get only name
            for (var i = 0; i < this.imageData.length; i++) {
                // Get the button
                var category = this.t.el(this.imageData[i].category);
                // For each image in this category create a thumbnail
                for (var j = 0; j < this.imageData[i].images.length; j++) {
                    var image = this.imageData[i].images[j];
                    this.addThumbImage(category, image, j, i);
                }
//                console.log(this.imageData);
                // make buttons containers
                this.changeButtonStyle(category);
            }
        };
        Thumbs.prototype.addThumbImage = function (category, image, image_id, category_id) {
            // Todo add to define
            category.innerHTML = category.innerHTML + '<img id="' + image.id + '" src="' + image.src + '" class="wally-thumb" ' + WGallery.Define.imageIdNumbPref + '="' + image_id + '" ' + WGallery.Define.categoryIdentifierIdAttr + '="' + category_id + '">';
        };
        Thumbs.prototype.changeButtonStyle = function (category) {
            category.style.borderRadius = '0';
            category.style.border = 'none';
            category.style.textAlign = 'left';
            category.style.cursor = 'default';
        };
        return Thumbs;
    })();
    WGallery.Thumbs = Thumbs;
})(WGallery || (WGallery = {}));
/**
 * Created by christospapidas on 260615--.
 */
/// <reference path="Define.ts"/>
/// <reference path="Tools.ts"/>
var WGallery;
(function (WGallery) {
    var Popup = (function () {
        function Popup() {
            var _this = this;
            this.t = new WGallery.Tools();
            this.closePopup = function () {
                _this.t.addStyle(WGallery.Define.popupId, 'display', 'none');
            };
            this.popup = this.t.el(WGallery.Define.popupId);
        }
        Popup.prototype.loadImage = function (imagePath) {
            this.t.el(WGallery.Define.popupContent).innerHTML = WGallery.Define.popupImg(imagePath);
        };
        Popup.prototype.openPopup = function () {
            this.t.addStyle(WGallery.Define.popupId, 'display', 'block');
        };
        Popup.prototype.addImageLength = function (imageLength) {
            this.t.el(WGallery.Define.imagesLength).innerHTML = imageLength.toString();
        };
        Popup.prototype.addCurrentImage = function (currentImage) {
            this.t.el(WGallery.Define.currentImageIndex).innerHTML = currentImage.toString();
        };
        Popup.prototype.addTitleImage = function (imageTitle) {
            this.t.el(WGallery.Define.imageTitle).innerHTML = imageTitle;
        };
        Popup.prototype.addPopup = function () {
            if(this.t.el(WGallery.Define.wally)){
                (this.t.el(WGallery.Define.wally)).innerHTML += WGallery.Define.popupHtml;
                this.addEventListeners();
            }
        };
        Popup.prototype.addEventListeners = function () {
            this.t.el(WGallery.Define.popupCloseId).addEventListener('click', this.closePopup, false);
        };
        return Popup;
    })();
    WGallery.Popup = Popup;
})(WGallery || (WGallery = {}));
/**
 * Created by christospapidas on 260615--.
 */
/// <reference path="Define.ts"/>
/// <reference path="IImageData.ts"/>
/// <reference path="Tools.ts"/>
/// <reference path="Popup.ts"/>
/// <reference path="Thumbs.ts"/>
var WGallery;
(function (WGallery) {
    var Manager = (function () {
        function Manager() {
            this.categories = [];
            this.imageData = [];
            this.popup = new WGallery.Popup();
            this.t = new WGallery.Tools();
            // Store data structure into imageData array
            //this.createDataStructure();
        }
        Manager.prototype.getImageData = function () {
            return this.imageData;
        };
        /**
         * Create the data structure
         */
        Manager.prototype.createDataStructure = function () {
            // Get all categories' elements
            var listOfCategories = this.t.byClass(WGallery.Define.categoryIdentifier);
            // For each category name get only name
            for (var i = 0; i < listOfCategories.length; i++) {
                var categoryButton = listOfCategories[i];
                // Add key to element
                categoryButton.setAttribute(WGallery.Define.categoryIdentifierIdAttr, i.toString());
                var category = listOfCategories[i].id;
                // Display categories
                this.displayType(categoryButton);
                // get all children for this category
                var categoryChildren = this.t.byClass(category);
                // WGallery.Define images array
                var images = [];
                // Add all children into images array
                for (var j = 0; j < categoryChildren.length; j++) {
                    var imageId = WGallery.Define.imageIdPref + i + j;
                    var imagePath = this.t.attrE(categoryChildren[j], WGallery.Define.imagePathAttr);
                    var imageTitle = this.t.attrE(categoryChildren[j], WGallery.Define.imageTitleAttr);
                    images.push({ id: imageId, src: imagePath, title: imageTitle });
                }
                // push the image data
                this.imageData.push({ category: category, images: images });
            }
            if (Manager.displayTypeString == WGallery.Define.displayTypeBlock) {
                new WGallery.Thumbs(this.imageData);
            }
        };
        /**
         * Next Slider Logic
         */
        Manager.prototype.nextSlide = function () {
            // Get the current category and image indexes
            var categoryIndex = Manager.currentCategory;
            var imageIndex = Manager.currentImageIndex;
            // If you are in last image then go to first when you press the next slide button
            if (this.imageData[categoryIndex].images.length - 2 < Manager.currentImageIndex) {
                imageIndex = 0;
            }
            else {
                imageIndex = 1 + imageIndex;
            }
            // Load the Image
            this.popupLoadImage(categoryIndex, imageIndex);
            Manager.currentImageIndex = imageIndex;
        };
        /**
         * Prev Slide Logic
         */
        Manager.prototype.prevSlide = function () {
            // Get the current category and image indexes
            var categoryIndex = Manager.currentCategory;
            var imageIndex = Manager.currentImageIndex;
            // If we are at fist image go to the end
            if (imageIndex <= 0) {
                imageIndex = this.imageData[categoryIndex].images.length - 1;
            }
            else {
                imageIndex = imageIndex - 1;
            }
            // Load the image
            this.popupLoadImage(categoryIndex, imageIndex);
            Manager.currentImageIndex = imageIndex;
        };
        /**
         * Load the image
         * @param categoryIndex
         * @param imageIndex
         */
        Manager.prototype.popupLoadImage = function (categoryIndex, imageIndex) {
            Manager.currentImageIndex = imageIndex;
            var imagePath = this.imageData[categoryIndex].images[imageIndex].src;
            this.popup.loadImage(imagePath);
            var imageTitle = this.imageData[categoryIndex].images[imageIndex].title;
            var currentImageIndex = imageIndex + 1;
            var imageLength = this.imageData[categoryIndex].images.length;
            this.popup.addCurrentImage(currentImageIndex);
            this.popup.addImageLength(imageLength);
            this.popup.addTitleImage(imageTitle);
        };
        Manager.prototype.displayType = function (button) {
            // If display type already defined - leave
            if (Manager.displayTypeString) {
            }
            else {
                // Get the attr display type
                Manager.displayTypeString = this.t.attrE(button, WGallery.Define.buttonDisplayGalleryAttr);
            }
            //console.log(Manager.displayTypeString);
            if (Manager.displayTypeString == null) {
                Manager.displayTypeString = WGallery.Define.displayTypeCategories;
            }
            // if display == categories
            if (Manager.displayTypeString == WGallery.Define.displayTypeCategories) {
                var coverImage = this.t.attrE(button, WGallery.Define.buttonCoverImage);
                button.style.background = 'url("' + coverImage + '") no-repeat center center';
            }
            else if (Manager.displayTypeString == WGallery.Define.displayTypeBlock) {
                button.innerHTML = "";
            }
        };
        /**
         * Get The categories
         * @returns {string[]}
         */
        Manager.prototype.getCategories = function () {
            return this.categories;
        };
        /**
         * Push the categories array
         * @param category
         */
        Manager.prototype.pushCategories = function (category) {
            this.categories.push(category);
        };
        Manager.currentCategory = 0;
        Manager.currentImageIndex = 0;
        Manager.displayTypeString = null;
        Manager.defaultDisplayType = 'block';
        return Manager;
    })();
    WGallery.Manager = Manager;
})(WGallery || (WGallery = {}));
/**
 * Created by christospapidas on 260615--.
 */
/// <reference path="IImageData.ts"/>
/// <reference path="Tools.ts"/>
/// <reference path="Define.ts"/>
/// <reference path="Popup.ts"/>
/// <reference path="Manager.ts"/>
var WGallery;
(function (WGallery) {
    var Events = (function () {
        function Events(imageData, manager) {
            var _this = this;
            this.t = new WGallery.Tools();
            this.imageData = [];
            this.popup = new WGallery.Popup();
            /**
             * Next slide
             * @param e
             */
            this.nextSlide = function (e) {
                _this.manager.nextSlide();
            };
            /**
             * Prev Slide
             * @param e
             */
            this.prevSlide = function (e) {
                _this.manager.prevSlide();
            };
            /**
             * Open popup
             * @param e
             */
            this.buttonPopup = function (e) {
                // Find which category clicked and get the data
                var buttonId = e.target.id;
//                console.log('button id is:', buttonId);
                var categoryId = +_this.t.attr(buttonId, WGallery.Define.categoryIdentifierIdAttr);
                var isblock = false;
                var imageId = 0;
                if (WGallery.Manager.displayTypeString == WGallery.Define.displayTypeBlock) {
                    imageId = +_this.t.attr(buttonId, WGallery.Define.imageIdNumbPref);
                }
                var imageData = _this.imageData[categoryId];
                // Open the popup
                _this.popup.openPopup();
                _this.manager.popupLoadImage(categoryId, imageId);
                WGallery.Manager.currentImageIndex = imageId;
                WGallery.Manager.currentCategory = categoryId;
            };
            this.imageData = imageData;
            this.generateClickListenners();
            this.manager = manager;
        }
        /**
         * Add event listeners
         */
        Events.prototype.generateClickListenners = function () {
            var _this = this;
            //For each category's button add the event listener
            for (var i = 0; i < this.imageData.length; i++) {
                var category = this.imageData[i].category;
//                console.log('category is: ', category)
                var buttonCategory = this.t.el(category);
//                console.log('buttonCategory is: ', buttonCategory)

                // If current display option is category
                if (WGallery.Manager.displayTypeString == WGallery.Define.displayTypeCategories) {
                    buttonCategory.addEventListener('click', function (e) {
//                        e.preventDefault();
//                        console.log('this is: ', _this);
                        _this.buttonPopup(e);
                    });
                }
                // If current display option is block
                if (WGallery.Manager.displayTypeString == WGallery.Define.displayTypeBlock) {
                    // For each category name get only name
                    for (var j = 0; j < this.imageData[i].images.length; j++) {
                        {
                            var currentImage = this.t.el(this.imageData[i].images[j].id);
                            currentImage.addEventListener('click', function (e) {
                                _this.buttonPopup(e);
                            });
                        }
                    }
                }
                // Prev slide add event listener
                this.t.el(WGallery.Define.popupPrev).addEventListener('click', this.prevSlide, false);
                // Next slide add event listener
                this.t.el(WGallery.Define.popupNext).addEventListener('click', this.nextSlide, false);
            }
        };
        return Events;
    })();
    WGallery.Events = Events;
})(WGallery || (WGallery = {}));
/**
 * Created by christospapidas on 260615--.
 */
/// <reference path="Manager.ts"/>
/// <reference path="Events.ts"/>
/// <reference path="Popup.ts"/>
/// <reference path="Define.ts"/>
var WGallery;
(function (WGallery) {
    var Wally = (function () {
        function Wally() {
            this.dataStructure = [];
            // Set up define
            this.define = new WGallery.Define();
            this.popup = new WGallery.Popup();
            this.popup.addPopup();
            // Get the image data from html
            this.manager = new WGallery.Manager();
            this.manager.createDataStructure();
            this.dataStructure = this.manager.getImageData();
            // Setup the events
            this.events = new WGallery.Events(this.dataStructure, this.manager);
        }
        return Wally;
    })();
    WGallery.Wally = Wally;
})(WGallery || (WGallery = {}));
new WGallery.Wally();
