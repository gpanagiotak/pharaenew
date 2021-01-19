/*!
 * jquery.customSelect() - v0.4.1
 * http://adam.co/lab/jquery/customselect/
 * 2013-05-13
 *
 * Copyright 2013 Adam Coulombe
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @license http://www.gnu.org/licenses/gpl.html GPL2 License
 */
(function ($) {
    $.fn.extend({
        customSelect: function (options) {
            if (typeof document.body.style.maxHeight === "undefined") {
                return this;
            }
            var defaults = { customClass: "customSelect", mapClass: true, mapStyle: true },
                options = $.extend(defaults, options),
                prefix = options.customClass,
                changed = function ($select, customSelectSpan) {
                    var currentSelected = $select.find(":selected"),
                        customSelectSpanInner = customSelectSpan.children(":first"),
                        html = currentSelected.html() || "&nbsp;";
                    customSelectSpanInner.html(html);
                    if (currentSelected.attr("disabled")) {
                        customSelectSpan.addClass(getClass("DisabledOption"));
                    } else {
                        customSelectSpan.removeClass(getClass("DisabledOption"));
                    }
                    setTimeout(function () {
                        customSelectSpan.removeClass(getClass("Open"));
                        $(document).off("mouseup." + getClass("Open"));
                    }, 60);
                },
                getClass = function (suffix) {
                    return prefix + suffix;
                };
            return this.each(function () {
                var $select = $(this),
                    customSelectInnerSpan = $("<span />").addClass(getClass("Inner")),
                    customSelectSpan = $("<span />");
                $select.after(customSelectSpan.append(customSelectInnerSpan));
                customSelectSpan.addClass(prefix);
                if (options.mapClass) {
                    customSelectSpan.addClass($select.attr("class"));
                }
                if (options.mapStyle) {
                    customSelectSpan.attr("style", $select.attr("style"));
                }
                $select
                    .addClass("hasCustomSelect")
                    .on("update", function () {
                        changed($select, customSelectSpan);
                        var selectBoxWidth = parseInt($select.outerWidth(), 10) - (parseInt(customSelectSpan.outerWidth(), 10) - parseInt(customSelectSpan.width(), 10));
                        customSelectSpan.css({ display: "inline-block" });
                        var selectBoxHeight = customSelectSpan.outerHeight();
                        if ($select.attr("disabled")) {
                            customSelectSpan.addClass(getClass("Disabled"));
                        } else {
                            customSelectSpan.removeClass(getClass("Disabled"));
                        }
                        customSelectInnerSpan.css({ width: selectBoxWidth, display: "inline-block" });
                        $select.css({ "-webkit-appearance": "menulist-button", width: customSelectSpan.outerWidth(), position: "absolute", opacity: 0, height: selectBoxHeight, fontSize: customSelectSpan.css("font-size") });
                    })
                    .on("change", function () {
                        customSelectSpan.addClass(getClass("Changed"));
                        changed($select, customSelectSpan);
                    })
                    .on("keyup", function (e) {
                        if (!customSelectSpan.hasClass(getClass("Open"))) {
                            $select.blur();
                            $select.focus();
                        } else {
                            if (e.which == 13 || e.which == 27) {
                                changed($select, customSelectSpan);
                            }
                        }
                    })
                    .on("mousedown", function (e) {
                        customSelectSpan.removeClass(getClass("Changed"));
                    })
                    .on("mouseup", function (e) {
                        if (!customSelectSpan.hasClass(getClass("Open"))) {
                            if ($("." + getClass("Open")).not(customSelectSpan).length > 0 && typeof InstallTrigger !== "undefined") {
                                $select.focus();
                            } else {
                                customSelectSpan.addClass(getClass("Open"));
                                e.stopPropagation();
                                $(document).one("mouseup." + getClass("Open"), function (e) {
                                    if (e.target != $select.get(0) && $.inArray(e.target, $select.find("*").get()) < 0) {
                                        $select.blur();
                                    } else {
                                        changed($select, customSelectSpan);
                                    }
                                });
                            }
                        }
                    })
                    .focus(function () {
                        customSelectSpan.removeClass(getClass("Changed")).addClass(getClass("Focus"));
                    })
                    .blur(function () {
                        customSelectSpan.removeClass(getClass("Focus") + " " + getClass("Open"));
                    })
                    .hover(
                        function () {
                            customSelectSpan.addClass(getClass("Hover"));
                        },
                        function () {
                            customSelectSpan.removeClass(getClass("Hover"));
                        }
                    )
                    .trigger("update");
            });
        },
    });
})(jQuery);
(function ($) {
    var defaults = { topSpacing: 0, bottomSpacing: 0, className: "is-sticky", wrapperClassName: "sticky-wrapper", center: false, getWidthFrom: "" },
        $window = $(window),
        $document = $(document),
        sticked = [],
        windowHeight = $window.height(),
        scroller = function () {
            var scrollTop = $window.scrollTop(),
                documentHeight = $document.height(),
                dwh = documentHeight - windowHeight,
                extra = scrollTop > dwh ? dwh - scrollTop : 0;
            for (var i = 0; i < sticked.length; i++) {
                var s = sticked[i],
                    elementTop = s.stickyWrapper.offset().top,
                    etse = elementTop - s.topSpacing - extra;
                if (scrollTop <= etse) {
                    if (s.currentTop !== null) {
                        s.stickyElement.css("position", "").css("top", "");
                        s.stickyElement.parent().removeClass(s.className);
                        s.currentTop = null;
                    }
                } else {
                    var newTop = documentHeight - s.stickyElement.outerHeight() - s.topSpacing - s.bottomSpacing - scrollTop - extra;
                    if (newTop < 0) {
                        newTop = newTop + s.topSpacing;
                    } else {
                        newTop = s.topSpacing;
                    }
                    if (s.currentTop != newTop) {
                        s.stickyElement.css("position", "fixed").css("top", newTop);
                        if (typeof s.getWidthFrom !== "undefined") {
                            s.stickyElement.css("width", $(s.getWidthFrom).width());
                        }
                        s.stickyElement.parent().addClass(s.className);
                        s.currentTop = newTop;
                    }
                }
            }
        },
        resizer = function () {
            windowHeight = $window.height();
        },
        methods = {
            init: function (options) {
                var o = $.extend(defaults, options);
                return this.each(function () {
                    var stickyElement = $(this);
                    var stickyId = stickyElement.attr("id");
                    var wrapper = $("<div></div>")
                        .attr("id", stickyId + "-sticky-wrapper")
                        .addClass(o.wrapperClassName);
                    stickyElement.wrapAll(wrapper);
                    if (o.center) {
                        stickyElement.parent().css({ width: stickyElement.outerWidth(), marginLeft: "auto", marginRight: "auto" });
                    }
                    if (stickyElement.css("float") == "right") {
                        stickyElement.css({ float: "none" }).parent().css({ float: "right" });
                    }
                    var stickyWrapper = stickyElement.parent();
                    stickyWrapper.css("height", stickyElement.outerHeight());
                    sticked.push({ topSpacing: o.topSpacing, bottomSpacing: o.bottomSpacing, stickyElement: stickyElement, currentTop: null, stickyWrapper: stickyWrapper, className: o.className, getWidthFrom: o.getWidthFrom });
                });
            },
            update: scroller,
        };
    if (window.addEventListener) {
        window.addEventListener("scroll", scroller, false);
        window.addEventListener("resize", resizer, false);
    } else {
        if (window.attachEvent) {
            window.attachEvent("onscroll", scroller);
            window.attachEvent("onresize", resizer);
        }
    }
    $.fn.sticky = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else {
            if (typeof method === "object" || !method) {
                return methods.init.apply(this, arguments);
            } else {
                $.error("Method " + method + " does not exist on jQuery.sticky");
            }
        }
    };
    $(function () {
        setTimeout(scroller, 0);
    });
})(jQuery);
(function ($, window, google, undefined) {
    var html_dropdown, html_ullist, Maplace;
    html_dropdown = {
        activateCurrent: function (index) {
            this.html_element.find("select").val(index);
        },
        getHtml: function () {
            var self = this,
                html = "",
                title,
                a;
            if (this.ln > 1) {
                html += '<select class="dropdown controls ' + this.o.controls_cssclass + '">';
                if (this.ShowOnMenu(this.view_all_key)) {
                    html += '<option value="' + this.view_all_key + '">' + this.o.view_all_text + "</option>";
                }
                for (a = 0; a < this.ln; a += 1) {
                    if (this.ShowOnMenu(a)) {
                        html += '<option value="' + (a + 1) + '">' + (this.o.locations[a].title || "#" + (a + 1)) + "</option>";
                    }
                }
                html += "</select>";
                html = $(html).bind("change", function () {
                    self.ViewOnMap(this.value);
                });
            }
            title = this.o.controls_title;
            if (this.o.controls_title) {
                title = $('<div class="controls_title"></div>')
                    .css(this.o.controls_applycss ? { fontWeight: "bold", fontSize: this.o.controls_on_map ? "12px" : "inherit", padding: "3px 10px 5px 0" } : {})
                    .append(this.o.controls_title);
            }
            this.html_element = $('<div class="wrap_controls"></div>').append(title).append(html);
            return this.html_element;
        },
    };
    html_ullist = {
        html_a: function (i, hash, ttl) {
            var self = this,
                index = hash || i + 1,
                title = ttl || this.o.locations[i].title,
                el_a = $('<a data-load="' + index + '" id="ullist_a_' + index + '" href="#' + index + '" title="' + title + '"><span>' + (title || "#" + (i + 1)) + "</span></a>");
            el_a.css(this.o.controls_applycss ? { color: "#666", display: "block", padding: "5px", fontSize: this.o.controls_on_map ? "12px" : "inherit", textDecoration: "none" } : {});
            el_a.on("click", function (e) {
                e.preventDefault();
                var i = $(this).attr("data-load");
                self.ViewOnMap(i);
            });
            return el_a;
        },
        activateCurrent: function (index) {
            this.html_element.find("li").removeClass("active");
            this.html_element
                .find("#ullist_a_" + index)
                .parent()
                .addClass("active");
        },
        getHtml: function () {
            var html = $("<ul class='ullist controls " + this.o.controls_cssclass + "'></ul>").css(this.o.controls_applycss ? { margin: 0, padding: 0, listStyleType: "none" } : {}),
                title,
                a;
            if (this.ShowOnMenu(this.view_all_key)) {
                html.append($("<li></li>").append(html_ullist.html_a.call(this, false, this.view_all_key, this.o.view_all_text)));
            }
            for (a = 0; a < this.ln; a++) {
                if (this.ShowOnMenu(a)) {
                    html.append($("<li></li>").append(html_ullist.html_a.call(this, a)));
                }
            }
            title = this.o.controls_title;
            if (this.o.controls_title) {
                title = $('<div class="controls_title"></div>')
                    .css(this.o.controls_applycss ? { fontWeight: "bold", padding: "3px 10px 5px 0", fontSize: this.o.controls_on_map ? "12px" : "inherit" } : {})
                    .append(this.o.controls_title);
            }
            this.html_element = $('<div class="wrap_controls"></div>').append(title).append(html);
            return this.html_element;
        },
    };
    Maplace = (function () {
        function Maplace(args) {
            this.VERSION = "0.1.2";
            this.errors = [];
            this.loaded = false;
            this.dev = true;
            this.markers = [];
            this.oMap = false;
            this.view_all_key = "all";
            this.infowindow = null;
            this.ln = 0;
            this.oMap = false;
            this.oBounds = null;
            this.map_div = null;
            this.canvas_map = null;
            this.controls_wrapper = null;
            this.current_control = null;
            this.current_index = null;
            this.Polyline = null;
            this.Polygon = null;
            this.Fusion = null;
            this.directionsService = null;
            this.directionsDisplay = null;
            this.o = {
                map_div: "#gmap",
                controls_div: "#controls",
                generate_controls: true,
                controls_type: "dropdown",
                controls_cssclass: "",
                controls_title: "",
                controls_on_map: true,
                controls_applycss: true,
                controls_position: google.maps.ControlPosition.RIGHT_TOP,
                type: "marker",
                view_all: true,
                view_all_text: "View All",
                start: 0,
                locations: [],
                commons: {},
                map_options: { mapTypeId: google.maps.MapTypeId.ROADMAP, zoom: 1 },
                stroke_options: { strokeColor: "#0000FF", strokeOpacity: 0.8, strokeWeight: 2, fillColor: "#0000FF", fillOpacity: 0.4 },
                directions_options: { travelMode: google.maps.TravelMode.DRIVING, unitSystem: google.maps.UnitSystem.METRIC, optimizeWaypoints: false, provideRouteAlternatives: false, avoidHighways: false, avoidTolls: false },
                styles: {},
                fusion_options: {},
                directions_panel: null,
                draggable: false,
                show_infowindows: true,
                show_markers: true,
                infowindow_type: "bubble",
                listeners: {},
                beforeViewAll: function () {},
                afterViewAll: function () {},
                beforeShow: function (index, location, marker) {},
                afterShow: function (index, location, marker) {},
                afterCreateMarker: function (index, location, marker) {},
                beforeCloseInfowindow: function (index, location) {},
                afterCloseInfowindow: function (index, location) {},
                beforeOpenInfowindow: function (index, location, marker) {},
                afterOpenInfowindow: function (index, location, marker) {},
                afterRoute: function (distance, status, result) {},
                onPolylineClick: function (obj) {},
            };
            this.AddControl("dropdown", html_dropdown);
            this.AddControl("list", html_ullist);
            $.extend(true, this.o, args);
        }
        Maplace.prototype.controls = {};
        Maplace.prototype.create_objMap = function () {
            var self = this,
                count = 0,
                i;
            for (i in this.o.styles) {
                if (this.o.styles.hasOwnProperty(i)) {
                    if (count === 0) {
                        this.o.map_options.mapTypeControlOptions = { mapTypeIds: [google.maps.MapTypeId.ROADMAP] };
                    }
                    count++;
                    this.o.map_options.mapTypeControlOptions.mapTypeIds.push("map_style_" + count);
                }
            }
            if (!this.loaded) {
                try {
                    this.map_div.css({ position: "relative", overflow: "hidden" });
                    this.canvas_map = $("<div>").addClass("canvas_map").css({ width: "100%", height: "100%" }).appendTo(this.map_div);
                    this.oMap = new google.maps.Map(this.canvas_map.get(0), this.o.map_options);
                } catch (err) {
                    this.errors.push(err.toString());
                }
            } else {
                self.oMap.setOptions(this.o.map_options);
            }
            count = 0;
            for (i in this.o.styles) {
                if (this.o.styles.hasOwnProperty(i)) {
                    count++;
                    this.oMap.mapTypes.set("map_style_" + count, new google.maps.StyledMapType(this.o.styles[i], { name: i }));
                    this.oMap.setMapTypeId("map_style_" + count);
                }
            }
            this.debug("01");
        };
        Maplace.prototype.add_markers_to_objMap = function () {
            var a,
                type = this.o.type || "marker";
            switch (type) {
                case "marker":
                    for (a = 0; a < this.ln; a++) {
                        this.create.marker.call(this, a);
                    }
                    break;
                default:
                    this.create[type].apply(this);
                    break;
            }
        };
        Maplace.prototype.create = {
            marker: function (index) {
                var self = this,
                    point = this.o.locations[index],
                    html = point.html || "",
                    marker,
                    a,
                    point_infow,
                    image_w,
                    image_h,
                    latlng = new google.maps.LatLng(point.lat, point.lon),
                    orig_visible = point.visible === false ? false : true;
                $.extend(point, { position: latlng, map: this.oMap, zIndex: 10000, visible: this.o.show_markers === false ? false : orig_visible });
                if (point.image) {
                    image_w = point.image_w || 32;
                    image_h = point.image_h || 32;
                    $.extend(point, { icon: new google.maps.MarkerImage(point.image, new google.maps.Size(image_w, image_h), new google.maps.Point(0, 0), new google.maps.Point(image_w / 2, image_h / 2)) });
                }
                marker = new google.maps.Marker(point);
                a = google.maps.event.addListener(marker, "click", function () {
                    self.o.beforeShow(index, point, marker);
                    point_infow = point.show_infowindows === false ? false : true;
                    if (self.o.show_infowindows && point_infow) {
                        self.open_infowindow(index, marker);
                    }
                    self.oMap.panTo(latlng);
                    point.zoom && self.oMap.setZoom(point.zoom);
                    if (self.current_control && self.o.generate_controls && self.current_control.activateCurrent) {
                        self.current_control.activateCurrent.call(self, index + 1);
                    }
                    self.current_index = index;
                    self.o.afterShow(index, point, marker);
                });
                this.oBounds.extend(latlng);
                this.markers.push(marker);
                this.o.afterCreateMarker(index, point, marker);
                point.visible = orig_visible;
                return marker;
            },
            polyline: function () {
                var self = this,
                    a,
                    latlng,
                    path = [];
                for (a = 0; a < this.ln; a++) {
                    latlng = new google.maps.LatLng(this.o.locations[a].lat, this.o.locations[a].lon);
                    path.push(latlng);
                    this.create.marker.call(this, a);
                }
                $.extend(this.o.stroke_options, { path: path, map: this.oMap });
                this.Polyline ? this.Polyline.setOptions(this.o.stroke_options) : (this.Polyline = new google.maps.Polyline(this.o.stroke_options));
            },
            polygon: function () {
                var self = this,
                    a,
                    latlng,
                    path = [];
                for (a = 0; a < this.ln; a++) {
                    latlng = new google.maps.LatLng(this.o.locations[a].lat, this.o.locations[a].lon);
                    path.push(latlng);
                    this.create.marker.call(this, a);
                }
                $.extend(this.o.stroke_options, { paths: path, editable: this.o.draggable, map: this.oMap });
                this.Polygon ? this.Polygon.setOptions(this.o.stroke_options) : (this.Polygon = new google.maps.Polygon(this.o.stroke_options));
                google.maps.event.addListener(this.Polygon, "click", function (obj) {
                    self.o.onPolylineClick(obj);
                });
            },
            fusion: function () {
                $.extend(this.o.fusion_options, { styles: [this.o.stroke_options], map: this.oMap });
                this.Fusion ? this.Fusion.setOptions(this.o.fusion_options) : (this.Fusion = new google.maps.FusionTablesLayer(this.o.fusion_options));
            },
            directions: function () {
                var self = this,
                    a,
                    stopover,
                    latlng,
                    origin,
                    destination,
                    waypoints = [],
                    distance = 0;
                for (a = 0; a < this.ln; a++) {
                    latlng = new google.maps.LatLng(this.o.locations[a].lat, this.o.locations[a].lon);
                    if (a === 0) {
                        origin = latlng;
                    } else {
                        if (a === this.ln - 1) {
                            destination = latlng;
                        } else {
                            stopover = this.o.locations[a].stopover === true ? true : false;
                            waypoints.push({ location: latlng, stopover: stopover });
                        }
                    }
                    this.create.marker.call(this, a);
                }
                $.extend(this.o.directions_options, { origin: origin, destination: destination, waypoints: waypoints });
                this.directionsService || (this.directionsService = new google.maps.DirectionsService());
                this.directionsDisplay ? this.directionsDisplay.setOptions({ draggable: this.o.draggable }) : (this.directionsDisplay = new google.maps.DirectionsRenderer({ draggable: this.o.draggable }));
                this.directionsDisplay.setMap(this.oMap);
                if (this.o.directions_panel) {
                    this.o.directions_panel = $(this.o.directions_panel);
                    this.directionsDisplay.setPanel(this.o.directions_panel.get(0));
                }
                if (this.o.draggable) {
                    google.maps.event.addListener(this.directionsDisplay, "directions_changed", function () {
                        distance = self.compute_distance(self.directionsDisplay.directions);
                        self.o.afterRoute(distance);
                    });
                }
                this.directionsService.route(this.o.directions_options, function (result, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        distance = self.compute_distance(result);
                        self.directionsDisplay.setDirections(result);
                    }
                    self.o.afterRoute(distance, status, result);
                });
            },
        };
        Maplace.prototype.compute_distance = function (result) {
            var total = 0,
                i,
                myroute = result.routes[0],
                rlen = myroute.legs.length;
            for (i = 0; i < rlen; i++) {
                total += myroute.legs[i].distance.value;
            }
            return total;
        };
        Maplace.prototype.type_to_open = {
            bubble: function (location) {
                this.infowindow = new google.maps.InfoWindow({ content: location.html || "" });
            },
        };
        Maplace.prototype.open_infowindow = function (index, marker) {
            this.CloseInfoWindow();
            var point = this.o.locations[index],
                type = point.type || this.o.infowindow_type;
            if (point.html && this.type_to_open[type]) {
                this.o.beforeOpenInfowindow(index, point, marker);
                this.type_to_open[type].call(this, point);
                this.infowindow.open(this.oMap, marker);
                this.o.afterOpenInfowindow(index, point, marker);
            }
        };
        Maplace.prototype.get_html_controls = function () {
            if (this.controls[this.o.controls_type] && this.controls[this.o.controls_type].getHtml) {
                this.current_control = this.controls[this.o.controls_type];
                return this.current_control.getHtml.apply(this);
            }
            return "";
        };
        Maplace.prototype.generate_controls = function () {
            if (!this.o.controls_on_map) {
                this.controls_wrapper.empty();
                this.controls_wrapper.append(this.get_html_controls());
                return;
            }
            var cntr = $('<div class="on_gmap ' + this.o.controls_type + ' gmap_controls"></div>').css(this.o.controls_applycss ? { margin: "5px" } : {}),
                inner = $(this.get_html_controls()).css(
                    this.o.controls_applycss
                        ? {
                            background: "#fff",
                            padding: "5px",
                            border: "1px solid rgb(113,123,135)",
                            boxShadow: "rgba(0, 0, 0, 0.4) 0px 2px 4px",
                            maxHeight: this.map_div.find(".canvas_map").outerHeight() - 80,
                            minWidth: 100,
                            overflowY: "auto",
                            overflowX: "hidden",
                        }
                        : {}
                );
            cntr.append(inner);
            this.oMap.controls[this.o.controls_position].push(cntr.get(0));
        };
        Maplace.prototype.init_map = function () {
            var self = this,
                i = 0;
            this.Polyline && this.Polyline.setMap(null);
            this.Polygon && this.Polygon.setMap(null);
            this.Fusion && this.Fusion.setMap(null);
            this.directionsDisplay && this.directionsDisplay.setMap(null);
            if (this.markers) {
                for (i in this.markers) {
                    if (this.markers[i]) {
                        try {
                            this.markers[i].setMap(null);
                        } catch (err) {
                            self.errors.push(err);
                        }
                    }
                }
                this.markers.length = 0;
                this.markers = [];
            }
            if (this.o.controls_on_map && this.oMap.controls) {
                this.oMap.controls[this.o.controls_position].forEach(function (element, index) {
                    try {
                        self.oMap.controls[this.o.controls_position].removeAt(index);
                    } catch (err) {
                        self.errors.push(err);
                    }
                });
            }
            this.oBounds = new google.maps.LatLngBounds();
            this.debug("02");
        };
        Maplace.prototype.perform_load = function () {
            if (this.ln === 1) {
                this.oMap.setCenter(this.markers[0].getPosition());
                this.ViewOnMap(1);
            } else {
                if (this.ln === 0) {
                    if (this.o.map_options.set_center) {
                        this.oMap.setCenter(new google.maps.LatLng(this.o.map_options.set_center[0], this.o.map_options.set_center[1]));
                    } else {
                        this.oMap.fitBounds(this.oBounds);
                    }
                    this.oMap.setZoom(this.o.map_options.zoom);
                } else {
                    this.oMap.fitBounds(this.oBounds);
                    if (typeof (this.o.start - 0) === "number" && this.o.start > 0 && this.o.start <= this.ln) {
                        this.ViewOnMap(this.o.start);
                    } else {
                        this.ViewOnMap(this.view_all_key);
                    }
                }
            }
        };
        Maplace.prototype.debug = function (msg) {
            if (this.dev && this.errors.length) {
                console.log(msg + ": ", this.errors);
            }
        };
        Maplace.prototype.AddControl = function (name, func) {
            if (!name || !func) {
                return false;
            }
            this.controls[name] = func;
            return true;
        };
        Maplace.prototype.CloseInfoWindow = function () {
            if (this.infowindow && (this.current_index || this.current_index === 0)) {
                this.o.beforeCloseInfowindow(this.current_index, this.o.locations[this.current_index]);
                this.infowindow.close();
                this.infowindow = null;
                this.o.afterCloseInfowindow(this.current_index, this.o.locations[this.current_index]);
            }
        };
        Maplace.prototype.ShowOnMenu = function (index) {
            if (index === this.view_all_key && this.o.view_all && this.ln > 1) {
                return true;
            }
            index = parseInt(index, 10);
            if (typeof (index - 0) === "number" && index >= 0 && index < this.ln) {
                var visible = this.o.locations[index].visible === false ? false : true,
                    on_menu = this.o.locations[index].on_menu === false ? false : true;
                if (visible && on_menu) {
                    return true;
                }
            }
            return false;
        };
        Maplace.prototype.ViewOnMap = function (index) {
            if (index === this.view_all_key) {
                this.o.beforeViewAll();
                this.current_index = index;
                if (this.o.locations.length > 0 && this.o.generate_controls && this.current_control && this.current_control.activateCurrent) {
                    this.current_control.activateCurrent.apply(this, [index]);
                }
                this.oMap.fitBounds(this.oBounds);
                this.CloseInfoWindow();
                this.o.afterViewAll();
            } else {
                index = parseInt(index, 10);
                if (typeof (index - 0) === "number" && index > 0 && index <= this.ln) {
                    try {
                        google.maps.event.trigger(this.markers[index - 1], "click");
                    } catch (err) {
                        this.errors.push(err.toString());
                    }
                }
            }
            this.debug("03");
        };
        Maplace.prototype.SetLocations = function (locs, reload) {
            this.o.locations = locs;
            reload && this.Load();
        };
        Maplace.prototype.AddLocations = function (locs, reload) {
            var self = this;
            if ($.isArray(locs)) {
                $.each(locs, function (index, value) {
                    self.o.locations.push(value);
                });
            }
            if ($.isPlainObject(locs)) {
                this.o.locations.push(locs);
            }
            reload && this.Load();
        };
        Maplace.prototype.AddLocation = function (location, index, reload) {
            var self = this;
            if ($.isPlainObject(location)) {
                this.o.locations.splice(index, 0, location);
            }
            reload && this.Load();
        };
        Maplace.prototype.RemoveLocations = function (locs, reload) {
            var self = this,
                k = 0;
            if ($.isArray(locs)) {
                $.each(locs, function (index, value) {
                    if (value - k < self.ln) {
                        self.o.locations.splice(value - k, 1);
                    }
                    k++;
                });
            } else {
                if (locs < this.ln) {
                    this.o.locations.splice(locs, 1);
                }
            }
            reload && this.Load();
        };
        Maplace.prototype.Loaded = function () {
            return this.loaded;
        };
        Maplace.prototype._init = function () {
            this.ln = this.o.locations.length;
            for (var i = 0; i < this.ln; i++) {
                $.extend(this.o.locations[i], this.o.commons);
                if (this.o.locations[i].html) {
                    this.o.locations[i].html = this.o.locations[i].html.replace("%index", i + 1);
                    this.o.locations[i].html = this.o.locations[i].html.replace("%title", this.o.locations[i].title || "");
                }
            }
            this.map_div = $(this.o.map_div);
            this.controls_wrapper = $(this.o.controls_div);
        };
        Maplace.prototype.Load = function (args) {
            $.extend(true, this.o, args);
            args && args.locations && (this.o.locations = args.locations);
            this._init();
            this.o.visualRefresh === false ? (google.maps.visualRefresh = false) : (google.maps.visualRefresh = true);
            this.init_map();
            this.create_objMap();
            this.add_markers_to_objMap();
            if ((this.ln > 1 && this.o.generate_controls) || this.o.force_generate_controls) {
                this.o.generate_controls = true;
                this.generate_controls();
            } else {
                this.o.generate_controls = false;
            }
            var self = this;
            if (!this.loaded) {
                google.maps.event.addListenerOnce(this.oMap, "idle", function () {
                    self.perform_load();
                });
                google.maps.event.addListener(this.oMap, "resize", function () {
                    self.canvas_map.css({ width: self.map_div.width(), height: self.map_div.height() });
                });
                var i;
                for (i in this.o.listeners) {
                    var map = this.oMap,
                        myListener = this.o.listeners[i];
                    if (this.o.listeners.hasOwnProperty(i)) {
                        google.maps.event.addListener(this.oMap, i, function (event) {
                            myListener(map, event);
                        });
                    }
                }
            } else {
                this.perform_load();
            }
            this.loaded = true;
        };
        return Maplace;
    })();
    if (typeof define == "function" && define.amd) {
        define(function () {
            return Maplace;
        });
    } else {
        window.Maplace = Maplace;
    }
})(jQuery, this, google);

/*!
 * skrollr core
 *
 * Alexander Prinzhorn - https://github.com/Prinzhorn/skrollr
 *
 * Free to use under terms of MIT license
 */
(function (window, document, undefined) {
    var skrollr = {
        get: function () {
            return _instance;
        },
        init: function (options) {
            return _instance || new Skrollr(options);
        },
        VERSION: "0.6.22",
    };
    var hasProp = Object.prototype.hasOwnProperty;
    var Math = window.Math;
    var getStyle = window.getComputedStyle;
    var documentElement;
    var body;
    var EVENT_TOUCHSTART = "touchstart";
    var EVENT_TOUCHMOVE = "touchmove";
    var EVENT_TOUCHCANCEL = "touchcancel";
    var EVENT_TOUCHEND = "touchend";
    var SKROLLABLE_CLASS = "skrollable";
    var SKROLLABLE_BEFORE_CLASS = SKROLLABLE_CLASS + "-before";
    var SKROLLABLE_BETWEEN_CLASS = SKROLLABLE_CLASS + "-between";
    var SKROLLABLE_AFTER_CLASS = SKROLLABLE_CLASS + "-after";
    var SKROLLR_CLASS = "skrollr";
    var NO_SKROLLR_CLASS = "no-" + SKROLLR_CLASS;
    var SKROLLR_DESKTOP_CLASS = SKROLLR_CLASS + "-desktop";
    var SKROLLR_MOBILE_CLASS = SKROLLR_CLASS + "-mobile";
    var DEFAULT_EASING = "linear";
    var DEFAULT_DURATION = 1000;
    var DEFAULT_MOBILE_DECELERATION = 0.004;
    var DEFAULT_SMOOTH_SCROLLING_DURATION = 200;
    var ANCHOR_START = "start";
    var ANCHOR_END = "end";
    var ANCHOR_CENTER = "center";
    var ANCHOR_BOTTOM = "bottom";
    var SKROLLABLE_ID_DOM_PROPERTY = "___skrollable_id";
    var rxTouchIgnoreTags = /^(?:input|textarea|button|select)$/i;
    var rxTrim = /^\s+|\s+$/g;
    var rxKeyframeAttribute = /^data(?:-(_\w+))?(?:-?(-?\d*\.?\d+p?))?(?:-?(start|end|top|center|bottom))?(?:-?(top|center|bottom))?$/;
    var rxPropValue = /\s*([\w\-\[\]]+)\s*:\s*(.+?)\s*(?:;|$)/gi;
    var rxPropEasing = /^([a-z\-]+)\[(\w+)\]$/;
    var rxCamelCase = /-([a-z0-9_])/g;
    var rxCamelCaseFn = function (str, letter) {
        return letter.toUpperCase();
    };
    var rxNumericValue = /[\-+]?[\d]*\.?[\d]+/g;
    var rxInterpolateString = /\{\?\}/g;
    var rxRGBAIntegerColor = /rgba?\(\s*-?\d+\s*,\s*-?\d+\s*,\s*-?\d+/g;
    var rxGradient = /[a-z\-]+-gradient/g;
    var theCSSPrefix = "";
    var theDashedCSSPrefix = "";
    var detectCSSPrefix = function () {
        var rxPrefixes = /^(?:O|Moz|webkit|ms)|(?:-(?:o|moz|webkit|ms)-)/;
        if (!getStyle) {
            return;
        }
        var style = getStyle(body, null);
        for (var k in style) {
            theCSSPrefix = k.match(rxPrefixes) || (+k == k && style[k].match(rxPrefixes));
            if (theCSSPrefix) {
                break;
            }
        }
        if (!theCSSPrefix) {
            theCSSPrefix = theDashedCSSPrefix = "";
            return;
        }
        theCSSPrefix = theCSSPrefix[0];
        if (theCSSPrefix.slice(0, 1) === "-") {
            theDashedCSSPrefix = theCSSPrefix;
            theCSSPrefix = { "-webkit-": "webkit", "-moz-": "Moz", "-ms-": "ms", "-o-": "O" }[theCSSPrefix];
        } else {
            theDashedCSSPrefix = "-" + theCSSPrefix.toLowerCase() + "-";
        }
    };
    var polyfillRAF = function () {
        var requestAnimFrame = window.requestAnimationFrame || window[theCSSPrefix.toLowerCase() + "RequestAnimationFrame"];
        var lastTime = _now();
        if (_isMobile || !requestAnimFrame) {
            requestAnimFrame = function (callback) {
                var deltaTime = _now() - lastTime;
                var delay = Math.max(0, 1000 / 60 - deltaTime);
                return window.setTimeout(function () {
                    lastTime = _now();
                    callback();
                }, delay);
            };
        }
        return requestAnimFrame;
    };
    var polyfillCAF = function () {
        var cancelAnimFrame = window.cancelAnimationFrame || window[theCSSPrefix.toLowerCase() + "CancelAnimationFrame"];
        if (_isMobile || !cancelAnimFrame) {
            cancelAnimFrame = function (timeout) {
                return window.clearTimeout(timeout);
            };
        }
        return cancelAnimFrame;
    };
    var easings = {
        begin: function () {
            return 0;
        },
        end: function () {
            return 1;
        },
        linear: function (p) {
            return p;
        },
        quadratic: function (p) {
            return p * p;
        },
        cubic: function (p) {
            return p * p * p;
        },
        swing: function (p) {
            return -Math.cos(p * Math.PI) / 2 + 0.5;
        },
        sqrt: function (p) {
            return Math.sqrt(p);
        },
        outCubic: function (p) {
            return Math.pow(p - 1, 3) + 1;
        },
        bounce: function (p) {
            var a;
            if (p <= 0.5083) {
                a = 3;
            } else {
                if (p <= 0.8489) {
                    a = 9;
                } else {
                    if (p <= 0.96208) {
                        a = 27;
                    } else {
                        if (p <= 0.99981) {
                            a = 91;
                        } else {
                            return 1;
                        }
                    }
                }
            }
            return 1 - Math.abs((3 * Math.cos(p * a * 1.028)) / a);
        },
    };
    function Skrollr(options) {
        documentElement = document.documentElement;
        body = document.body;
        detectCSSPrefix();
        _instance = this;
        options = options || {};
        _constants = options.constants || {};
        if (options.easing) {
            for (var e in options.easing) {
                easings[e] = options.easing[e];
            }
        }
        _edgeStrategy = options.edgeStrategy || "set";
        _listeners = { beforerender: options.beforerender, render: options.render, keyframe: options.keyframe };
        _forceHeight = options.forceHeight !== false;
        if (_forceHeight) {
            _scale = options.scale || 1;
        }
        _mobileDeceleration = options.mobileDeceleration || DEFAULT_MOBILE_DECELERATION;
        _smoothScrollingEnabled = options.smoothScrolling !== false;
        _smoothScrollingDuration = options.smoothScrollingDuration || DEFAULT_SMOOTH_SCROLLING_DURATION;
        _smoothScrolling = { targetTop: _instance.getScrollTop() };
        _isMobile = (
            options.mobileCheck ||
            function () {
                return /Android|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent || navigator.vendor || window.opera);
            }
        )();
        if (_isMobile) {
            _skrollrBody = document.getElementById("skrollr-body");
            if (_skrollrBody) {
                _detect3DTransforms();
            }
            _initMobile();
            _updateClass(documentElement, [SKROLLR_CLASS, SKROLLR_MOBILE_CLASS], [NO_SKROLLR_CLASS]);
        } else {
            _updateClass(documentElement, [SKROLLR_CLASS, SKROLLR_DESKTOP_CLASS], [NO_SKROLLR_CLASS]);
        }
        _instance.refresh();
        _addEvent(window, "resize orientationchange", function () {
            var width = documentElement.clientWidth;
            var height = documentElement.clientHeight;
            if (height !== _lastViewportHeight || width !== _lastViewportWidth) {
                _lastViewportHeight = height;
                _lastViewportWidth = width;
                _requestReflow = true;
            }
        });
        var requestAnimFrame = polyfillRAF();
        (function animloop() {
            _render();
            _animFrame = requestAnimFrame(animloop);
        })();
        return _instance;
    }
    Skrollr.prototype.refresh = function (elements) {
        var elementIndex;
        var elementsLength;
        var ignoreID = false;
        if (elements === undefined) {
            ignoreID = true;
            _skrollables = [];
            _skrollableIdCounter = 0;
            elements = document.getElementsByTagName("*");
        } else {
            if (elements.length === undefined) {
                elements = [elements];
            }
        }
        elementIndex = 0;
        elementsLength = elements.length;
        for (; elementIndex < elementsLength; elementIndex++) {
            var el = elements[elementIndex];
            var anchorTarget = el;
            var keyFrames = [];
            var smoothScrollThis = _smoothScrollingEnabled;
            var edgeStrategy = _edgeStrategy;
            var emitEvents = false;
            if (ignoreID) {
                delete el[SKROLLABLE_ID_DOM_PROPERTY];
            }
            if (!el.attributes) {
                continue;
            }
            var attributeIndex = 0;
            var attributesLength = el.attributes.length;
            for (; attributeIndex < attributesLength; attributeIndex++) {
                var attr = el.attributes[attributeIndex];
                if (attr.name === "data-anchor-target") {
                    anchorTarget = document.querySelector(attr.value);
                    if (anchorTarget === null) {
                        throw 'Unable to find anchor target "' + attr.value + '"';
                    }
                    continue;
                }
                if (attr.name === "data-smooth-scrolling") {
                    smoothScrollThis = attr.value !== "off";
                    continue;
                }
                if (attr.name === "data-edge-strategy") {
                    edgeStrategy = attr.value;
                    continue;
                }
                if (attr.name === "data-emit-events") {
                    emitEvents = true;
                    continue;
                }
                var match = attr.name.match(rxKeyframeAttribute);
                if (match === null) {
                    continue;
                }
                var kf = { props: attr.value, element: el, eventType: attr.name.replace(rxCamelCase, rxCamelCaseFn) };
                keyFrames.push(kf);
                var constant = match[1];
                if (constant) {
                    kf.constant = constant.substr(1);
                }
                var offset = match[2];
                if (/p$/.test(offset)) {
                    kf.isPercentage = true;
                    kf.offset = (offset.slice(0, -1) | 0) / 100;
                } else {
                    kf.offset = offset | 0;
                }
                var anchor1 = match[3];
                var anchor2 = match[4] || anchor1;
                if (!anchor1 || anchor1 === ANCHOR_START || anchor1 === ANCHOR_END) {
                    kf.mode = "absolute";
                    if (anchor1 === ANCHOR_END) {
                        kf.isEnd = true;
                    } else {
                        if (!kf.isPercentage) {
                            kf.offset = kf.offset * _scale;
                        }
                    }
                } else {
                    kf.mode = "relative";
                    kf.anchors = [anchor1, anchor2];
                }
            }
            if (!keyFrames.length) {
                continue;
            }
            var styleAttr, classAttr;
            var id;
            if (!ignoreID && SKROLLABLE_ID_DOM_PROPERTY in el) {
                id = el[SKROLLABLE_ID_DOM_PROPERTY];
                styleAttr = _skrollables[id].styleAttr;
                classAttr = _skrollables[id].classAttr;
            } else {
                id = el[SKROLLABLE_ID_DOM_PROPERTY] = _skrollableIdCounter++;
                styleAttr = el.style.cssText;
                classAttr = _getClass(el);
            }
            _skrollables[id] = {
                element: el,
                styleAttr: styleAttr,
                classAttr: classAttr,
                anchorTarget: anchorTarget,
                keyFrames: keyFrames,
                smoothScrolling: smoothScrollThis,
                edgeStrategy: edgeStrategy,
                emitEvents: emitEvents,
                lastFrameIndex: -1,
            };
            _updateClass(el, [SKROLLABLE_CLASS], []);
        }
        _reflow();
        elementIndex = 0;
        elementsLength = elements.length;
        for (; elementIndex < elementsLength; elementIndex++) {
            var sk = _skrollables[elements[elementIndex][SKROLLABLE_ID_DOM_PROPERTY]];
            if (sk === undefined) {
                continue;
            }
            _parseProps(sk);
            _fillProps(sk);
        }
        return _instance;
    };
    Skrollr.prototype.relativeToAbsolute = function (element, viewportAnchor, elementAnchor) {
        var viewportHeight = documentElement.clientHeight;
        var box = element.getBoundingClientRect();
        var absolute = box.top;
        var boxHeight = box.bottom - box.top;
        if (viewportAnchor === ANCHOR_BOTTOM) {
            absolute -= viewportHeight;
        } else {
            if (viewportAnchor === ANCHOR_CENTER) {
                absolute -= viewportHeight / 2;
            }
        }
        if (elementAnchor === ANCHOR_BOTTOM) {
            absolute += boxHeight;
        } else {
            if (elementAnchor === ANCHOR_CENTER) {
                absolute += boxHeight / 2;
            }
        }
        absolute += _instance.getScrollTop();
        return (absolute + 0.5) | 0;
    };
    Skrollr.prototype.animateTo = function (top, options) {
        options = options || {};
        var now = _now();
        var scrollTop = _instance.getScrollTop();
        _scrollAnimation = {
            startTop: scrollTop,
            topDiff: top - scrollTop,
            targetTop: top,
            duration: options.duration || DEFAULT_DURATION,
            startTime: now,
            endTime: now + (options.duration || DEFAULT_DURATION),
            easing: easings[options.easing || DEFAULT_EASING],
            done: options.done,
        };
        if (!_scrollAnimation.topDiff) {
            if (_scrollAnimation.done) {
                _scrollAnimation.done.call(_instance, false);
            }
            _scrollAnimation = undefined;
        }
        return _instance;
    };
    Skrollr.prototype.stopAnimateTo = function () {
        if (_scrollAnimation && _scrollAnimation.done) {
            _scrollAnimation.done.call(_instance, true);
        }
        _scrollAnimation = undefined;
    };
    Skrollr.prototype.isAnimatingTo = function () {
        return !!_scrollAnimation;
    };
    Skrollr.prototype.isMobile = function () {
        return _isMobile;
    };
    Skrollr.prototype.setScrollTop = function (top, force) {
        _forceRender = force === true;
        if (_isMobile) {
            _mobileOffset = Math.min(Math.max(top, 0), _maxKeyFrame);
        } else {
            window.scrollTo(0, top);
        }
        return _instance;
    };
    Skrollr.prototype.getScrollTop = function () {
        if (_isMobile) {
            return _mobileOffset;
        } else {
            return window.pageYOffset || documentElement.scrollTop || body.scrollTop || 0;
        }
    };
    Skrollr.prototype.getMaxScrollTop = function () {
        return _maxKeyFrame;
    };
    Skrollr.prototype.on = function (name, fn) {
        _listeners[name] = fn;
        return _instance;
    };
    Skrollr.prototype.off = function (name) {
        delete _listeners[name];
        return _instance;
    };
    Skrollr.prototype.destroy = function () {
        var cancelAnimFrame = polyfillCAF();
        cancelAnimFrame(_animFrame);
        _removeAllEvents();
        _updateClass(documentElement, [NO_SKROLLR_CLASS], [SKROLLR_CLASS, SKROLLR_DESKTOP_CLASS, SKROLLR_MOBILE_CLASS]);
        var skrollableIndex = 0;
        var skrollablesLength = _skrollables.length;
        for (; skrollableIndex < skrollablesLength; skrollableIndex++) {
            _reset(_skrollables[skrollableIndex].element);
        }
        documentElement.style.overflow = body.style.overflow = "auto";
        documentElement.style.height = body.style.height = "auto";
        if (_skrollrBody) {
            skrollr.setStyle(_skrollrBody, "transform", "none");
        }
        _instance = undefined;
        _skrollrBody = undefined;
        _listeners = undefined;
        _forceHeight = undefined;
        _maxKeyFrame = 0;
        _scale = 1;
        _constants = undefined;
        _mobileDeceleration = undefined;
        _direction = "down";
        _lastTop = -1;
        _lastViewportWidth = 0;
        _lastViewportHeight = 0;
        _requestReflow = false;
        _scrollAnimation = undefined;
        _smoothScrollingEnabled = undefined;
        _smoothScrollingDuration = undefined;
        _smoothScrolling = undefined;
        _forceRender = undefined;
        _skrollableIdCounter = 0;
        _edgeStrategy = undefined;
        _isMobile = false;
        _mobileOffset = 0;
        _translateZ = undefined;
    };
    var _initMobile = function () {
        var initialElement;
        var initialTouchY;
        var initialTouchX;
        var currentElement;
        var currentTouchY;
        var currentTouchX;
        var lastTouchY;
        var deltaY;
        var initialTouchTime;
        var currentTouchTime;
        var lastTouchTime;
        var deltaTime;
        _addEvent(documentElement, [EVENT_TOUCHSTART, EVENT_TOUCHMOVE, EVENT_TOUCHCANCEL, EVENT_TOUCHEND].join(" "), function (e) {
            var touch = e.changedTouches[0];
            currentElement = e.target;
            while (currentElement.nodeType === 3) {
                currentElement = currentElement.parentNode;
            }
            currentTouchY = touch.clientY;
            currentTouchX = touch.clientX;
            currentTouchTime = e.timeStamp;
            if (!rxTouchIgnoreTags.test(currentElement.tagName)) {
                e.preventDefault();
            }
            switch (e.type) {
                case EVENT_TOUCHSTART:
                    if (initialElement) {
                        initialElement.blur();
                    }
                    _instance.stopAnimateTo();
                    initialElement = currentElement;
                    initialTouchY = lastTouchY = currentTouchY;
                    initialTouchX = currentTouchX;
                    initialTouchTime = currentTouchTime;
                    break;
                case EVENT_TOUCHMOVE:
                    if (rxTouchIgnoreTags.test(currentElement.tagName) && document.activeElement !== currentElement) {
                        e.preventDefault();
                    }
                    deltaY = currentTouchY - lastTouchY;
                    deltaTime = currentTouchTime - lastTouchTime;
                    _instance.setScrollTop(_mobileOffset - deltaY, true);
                    lastTouchY = currentTouchY;
                    lastTouchTime = currentTouchTime;
                    break;
                default:
                case EVENT_TOUCHCANCEL:
                case EVENT_TOUCHEND:
                    var distanceY = initialTouchY - currentTouchY;
                    var distanceX = initialTouchX - currentTouchX;
                    var distance2 = distanceX * distanceX + distanceY * distanceY;
                    if (distance2 < 49) {
                        if (!rxTouchIgnoreTags.test(initialElement.tagName)) {
                            initialElement.focus();
                            var clickEvent = document.createEvent("MouseEvents");
                            clickEvent.initMouseEvent("click", true, true, e.view, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, e.ctrlKey, e.altKey, e.shiftKey, e.metaKey, 0, null);
                            initialElement.dispatchEvent(clickEvent);
                        }
                        return;
                    }
                    initialElement = undefined;
                    var speed = deltaY / deltaTime;
                    speed = Math.max(Math.min(speed, 3), -3);
                    var duration = Math.abs(speed / _mobileDeceleration);
                    var targetOffset = speed * duration + 0.5 * _mobileDeceleration * duration * duration;
                    var targetTop = _instance.getScrollTop() - targetOffset;
                    var targetRatio = 0;
                    if (targetTop > _maxKeyFrame) {
                        targetRatio = (_maxKeyFrame - targetTop) / targetOffset;
                        targetTop = _maxKeyFrame;
                    } else {
                        if (targetTop < 0) {
                            targetRatio = -targetTop / targetOffset;
                            targetTop = 0;
                        }
                    }
                    duration = duration * (1 - targetRatio);
                    _instance.animateTo((targetTop + 0.5) | 0, { easing: "outCubic", duration: duration });
                    break;
            }
        });
        window.scrollTo(0, 0);
        documentElement.style.overflow = body.style.overflow = "hidden";
    };
    var _updateDependentKeyFrames = function () {
        var viewportHeight = documentElement.clientHeight;
        var processedConstants = _processConstants();
        var skrollable;
        var element;
        var anchorTarget;
        var keyFrames;
        var keyFrameIndex;
        var keyFramesLength;
        var kf;
        var skrollableIndex;
        var skrollablesLength;
        var offset;
        var constantValue;
        skrollableIndex = 0;
        skrollablesLength = _skrollables.length;
        for (; skrollableIndex < skrollablesLength; skrollableIndex++) {
            skrollable = _skrollables[skrollableIndex];
            element = skrollable.element;
            anchorTarget = skrollable.anchorTarget;
            keyFrames = skrollable.keyFrames;
            keyFrameIndex = 0;
            keyFramesLength = keyFrames.length;
            for (; keyFrameIndex < keyFramesLength; keyFrameIndex++) {
                kf = keyFrames[keyFrameIndex];
                offset = kf.offset;
                constantValue = processedConstants[kf.constant] || 0;
                kf.frame = offset;
                if (kf.isPercentage) {
                    offset = offset * viewportHeight;
                    kf.frame = offset;
                }
                if (kf.mode === "relative") {
                    _reset(element);
                    kf.frame = _instance.relativeToAbsolute(anchorTarget, kf.anchors[0], kf.anchors[1]) - offset;
                    _reset(element, true);
                }
                kf.frame += constantValue;
                if (_forceHeight) {
                    if (!kf.isEnd && kf.frame > _maxKeyFrame) {
                        _maxKeyFrame = kf.frame;
                    }
                }
            }
        }
        _maxKeyFrame = Math.max(_maxKeyFrame, _getDocumentHeight());
        skrollableIndex = 0;
        skrollablesLength = _skrollables.length;
        for (; skrollableIndex < skrollablesLength; skrollableIndex++) {
            skrollable = _skrollables[skrollableIndex];
            keyFrames = skrollable.keyFrames;
            keyFrameIndex = 0;
            keyFramesLength = keyFrames.length;
            for (; keyFrameIndex < keyFramesLength; keyFrameIndex++) {
                kf = keyFrames[keyFrameIndex];
                constantValue = processedConstants[kf.constant] || 0;
                if (kf.isEnd) {
                    kf.frame = _maxKeyFrame - kf.offset + constantValue;
                }
            }
            skrollable.keyFrames.sort(_keyFrameComparator);
        }
    };
    var _calcSteps = function (fakeFrame, actualFrame) {
        var skrollableIndex = 0;
        var skrollablesLength = _skrollables.length;
        for (; skrollableIndex < skrollablesLength; skrollableIndex++) {
            var skrollable = _skrollables[skrollableIndex];
            var element = skrollable.element;
            var frame = skrollable.smoothScrolling ? fakeFrame : actualFrame;
            var frames = skrollable.keyFrames;
            var framesLength = frames.length;
            var firstFrame = frames[0];
            var lastFrame = frames[frames.length - 1];
            var beforeFirst = frame < firstFrame.frame;
            var afterLast = frame > lastFrame.frame;
            var firstOrLastFrame = beforeFirst ? firstFrame : lastFrame;
            var emitEvents = skrollable.emitEvents;
            var lastFrameIndex = skrollable.lastFrameIndex;
            var key;
            var value;
            if (beforeFirst || afterLast) {
                if ((beforeFirst && skrollable.edge === -1) || (afterLast && skrollable.edge === 1)) {
                    continue;
                }
                if (beforeFirst) {
                    _updateClass(element, [SKROLLABLE_BEFORE_CLASS], [SKROLLABLE_AFTER_CLASS, SKROLLABLE_BETWEEN_CLASS]);
                    if (emitEvents && lastFrameIndex > -1) {
                        _emitEvent(element, firstFrame.eventType, _direction);
                        skrollable.lastFrameIndex = -1;
                    }
                } else {
                    _updateClass(element, [SKROLLABLE_AFTER_CLASS], [SKROLLABLE_BEFORE_CLASS, SKROLLABLE_BETWEEN_CLASS]);
                    if (emitEvents && lastFrameIndex < framesLength) {
                        _emitEvent(element, lastFrame.eventType, _direction);
                        skrollable.lastFrameIndex = framesLength;
                    }
                }
                skrollable.edge = beforeFirst ? -1 : 1;
                switch (skrollable.edgeStrategy) {
                    case "reset":
                        _reset(element);
                        continue;
                    case "ease":
                        frame = firstOrLastFrame.frame;
                        break;
                    default:
                    case "set":
                        var props = firstOrLastFrame.props;
                        for (key in props) {
                            if (hasProp.call(props, key)) {
                                value = _interpolateString(props[key].value);
                                skrollr.setStyle(element, key, value);
                            }
                        }
                        continue;
                }
            } else {
                if (skrollable.edge !== 0) {
                    _updateClass(element, [SKROLLABLE_CLASS, SKROLLABLE_BETWEEN_CLASS], [SKROLLABLE_BEFORE_CLASS, SKROLLABLE_AFTER_CLASS]);
                    skrollable.edge = 0;
                }
            }
            var keyFrameIndex = 0;
            for (; keyFrameIndex < framesLength - 1; keyFrameIndex++) {
                if (frame >= frames[keyFrameIndex].frame && frame <= frames[keyFrameIndex + 1].frame) {
                    var left = frames[keyFrameIndex];
                    var right = frames[keyFrameIndex + 1];
                    for (key in left.props) {
                        if (hasProp.call(left.props, key)) {
                            var progress = (frame - left.frame) / (right.frame - left.frame);
                            progress = left.props[key].easing(progress);
                            value = _calcInterpolation(left.props[key].value, right.props[key].value, progress);
                            value = _interpolateString(value);
                            skrollr.setStyle(element, key, value);
                        }
                    }
                    if (emitEvents) {
                        if (lastFrameIndex !== keyFrameIndex) {
                            if (_direction === "down") {
                                _emitEvent(element, left.eventType, _direction);
                            } else {
                                _emitEvent(element, right.eventType, _direction);
                            }
                            skrollable.lastFrameIndex = keyFrameIndex;
                        }
                    }
                    break;
                }
            }
        }
    };
    var _render = function () {
        if (_requestReflow) {
            _requestReflow = false;
            _reflow();
        }
        var renderTop = _instance.getScrollTop();
        var afterAnimationCallback;
        var now = _now();
        var progress;
        if (_scrollAnimation) {
            if (now >= _scrollAnimation.endTime) {
                renderTop = _scrollAnimation.targetTop;
                afterAnimationCallback = _scrollAnimation.done;
                _scrollAnimation = undefined;
            } else {
                progress = _scrollAnimation.easing((now - _scrollAnimation.startTime) / _scrollAnimation.duration);
                renderTop = (_scrollAnimation.startTop + progress * _scrollAnimation.topDiff) | 0;
            }
            _instance.setScrollTop(renderTop, true);
        } else {
            if (!_forceRender) {
                var smoothScrollingDiff = _smoothScrolling.targetTop - renderTop;
                if (smoothScrollingDiff) {
                    _smoothScrolling = { startTop: _lastTop, topDiff: renderTop - _lastTop, targetTop: renderTop, startTime: _lastRenderCall, endTime: _lastRenderCall + _smoothScrollingDuration };
                }
                if (now <= _smoothScrolling.endTime) {
                    progress = easings.sqrt((now - _smoothScrolling.startTime) / _smoothScrollingDuration);
                    renderTop = (_smoothScrolling.startTop + progress * _smoothScrolling.topDiff) | 0;
                }
            }
        }
        if (_isMobile && _skrollrBody) {
            skrollr.setStyle(_skrollrBody, "transform", "translate(0, " + -_mobileOffset + "px) " + _translateZ);
        }
        if (_forceRender || _lastTop !== renderTop) {
            _direction = renderTop > _lastTop ? "down" : renderTop < _lastTop ? "up" : _direction;
            _forceRender = false;
            var listenerParams = { curTop: renderTop, lastTop: _lastTop, maxTop: _maxKeyFrame, direction: _direction };
            var continueRendering = _listeners.beforerender && _listeners.beforerender.call(_instance, listenerParams);
            if (continueRendering !== false) {
                _calcSteps(renderTop, _instance.getScrollTop());
                _lastTop = renderTop;
                if (_listeners.render) {
                    _listeners.render.call(_instance, listenerParams);
                }
            }
            if (afterAnimationCallback) {
                afterAnimationCallback.call(_instance, false);
            }
        }
        _lastRenderCall = now;
    };
    var _parseProps = function (skrollable) {
        var keyFrameIndex = 0;
        var keyFramesLength = skrollable.keyFrames.length;
        for (; keyFrameIndex < keyFramesLength; keyFrameIndex++) {
            var frame = skrollable.keyFrames[keyFrameIndex];
            var easing;
            var value;
            var prop;
            var props = {};
            var match;
            while ((match = rxPropValue.exec(frame.props)) !== null) {
                prop = match[1];
                value = match[2];
                easing = prop.match(rxPropEasing);
                if (easing !== null) {
                    prop = easing[1];
                    easing = easing[2];
                } else {
                    easing = DEFAULT_EASING;
                }
                value = value.indexOf("!") ? _parseProp(value) : [value.slice(1)];
                props[prop] = { value: value, easing: easings[easing] };
            }
            frame.props = props;
        }
    };
    var _parseProp = function (val) {
        var numbers = [];
        rxRGBAIntegerColor.lastIndex = 0;
        val = val.replace(rxRGBAIntegerColor, function (rgba) {
            return rgba.replace(rxNumericValue, function (n) {
                return (n / 255) * 100 + "%";
            });
        });
        if (theDashedCSSPrefix) {
            rxGradient.lastIndex = 0;
            val = val.replace(rxGradient, function (s) {
                return theDashedCSSPrefix + s;
            });
        }
        val = val.replace(rxNumericValue, function (n) {
            numbers.push(+n);
            return "{?}";
        });
        numbers.unshift(val);
        return numbers;
    };
    var _fillProps = function (sk) {
        var propList = {};
        var keyFrameIndex;
        var keyFramesLength;
        keyFrameIndex = 0;
        keyFramesLength = sk.keyFrames.length;
        for (; keyFrameIndex < keyFramesLength; keyFrameIndex++) {
            _fillPropForFrame(sk.keyFrames[keyFrameIndex], propList);
        }
        propList = {};
        keyFrameIndex = sk.keyFrames.length - 1;
        for (; keyFrameIndex >= 0; keyFrameIndex--) {
            _fillPropForFrame(sk.keyFrames[keyFrameIndex], propList);
        }
    };
    var _fillPropForFrame = function (frame, propList) {
        var key;
        for (key in propList) {
            if (!hasProp.call(frame.props, key)) {
                frame.props[key] = propList[key];
            }
        }
        for (key in frame.props) {
            propList[key] = frame.props[key];
        }
    };
    var _calcInterpolation = function (val1, val2, progress) {
        var valueIndex;
        var val1Length = val1.length;
        if (val1Length !== val2.length) {
            throw "Can't interpolate between \"" + val1[0] + '" and "' + val2[0] + '"';
        }
        var interpolated = [val1[0]];
        valueIndex = 1;
        for (; valueIndex < val1Length; valueIndex++) {
            interpolated[valueIndex] = val1[valueIndex] + (val2[valueIndex] - val1[valueIndex]) * progress;
        }
        return interpolated;
    };
    var _interpolateString = function (val) {
        var valueIndex = 1;
        rxInterpolateString.lastIndex = 0;
        return val[0].replace(rxInterpolateString, function () {
            return val[valueIndex++];
        });
    };
    var _reset = function (elements, undo) {
        elements = [].concat(elements);
        var skrollable;
        var element;
        var elementsIndex = 0;
        var elementsLength = elements.length;
        for (; elementsIndex < elementsLength; elementsIndex++) {
            element = elements[elementsIndex];
            skrollable = _skrollables[element[SKROLLABLE_ID_DOM_PROPERTY]];
            if (!skrollable) {
                continue;
            }
            if (undo) {
                element.style.cssText = skrollable.dirtyStyleAttr;
                _updateClass(element, skrollable.dirtyClassAttr);
            } else {
                skrollable.dirtyStyleAttr = element.style.cssText;
                skrollable.dirtyClassAttr = _getClass(element);
                element.style.cssText = skrollable.styleAttr;
                _updateClass(element, skrollable.classAttr);
            }
        }
    };
    var _detect3DTransforms = function () {
        _translateZ = "translateZ(0)";
        skrollr.setStyle(_skrollrBody, "transform", _translateZ);
        var computedStyle = getStyle(_skrollrBody);
        var computedTransform = computedStyle.getPropertyValue("transform");
        var computedTransformWithPrefix = computedStyle.getPropertyValue(theDashedCSSPrefix + "transform");
        var has3D = (computedTransform && computedTransform !== "none") || (computedTransformWithPrefix && computedTransformWithPrefix !== "none");
        if (!has3D) {
            _translateZ = "";
        }
    };
    skrollr.setStyle = function (el, prop, val) {
        var style = el.style;
        prop = prop.replace(rxCamelCase, rxCamelCaseFn).replace("-", "");
        if (prop === "zIndex") {
            if (isNaN(val)) {
                style[prop] = val;
            } else {
                style[prop] = "" + (val | 0);
            }
        } else {
            if (prop === "float") {
                style.styleFloat = style.cssFloat = val;
            } else {
                try {
                    if (theCSSPrefix) {
                        style[theCSSPrefix + prop.slice(0, 1).toUpperCase() + prop.slice(1)] = val;
                    }
                    style[prop] = val;
                } catch (ignore) {}
            }
        }
    };
    var _addEvent = (skrollr.addEvent = function (element, names, callback) {
        var intermediate = function (e) {
            e = e || window.event;
            if (!e.target) {
                e.target = e.srcElement;
            }
            if (!e.preventDefault) {
                e.preventDefault = function () {
                    e.returnValue = false;
                    e.defaultPrevented = true;
                };
            }
            return callback.call(this, e);
        };
        names = names.split(" ");
        var name;
        var nameCounter = 0;
        var namesLength = names.length;
        for (; nameCounter < namesLength; nameCounter++) {
            name = names[nameCounter];
            if (element.addEventListener) {
                element.addEventListener(name, callback, false);
            } else {
                element.attachEvent("on" + name, intermediate);
            }
            _registeredEvents.push({ element: element, name: name, listener: callback });
        }
    });
    var _removeEvent = (skrollr.removeEvent = function (element, names, callback) {
        names = names.split(" ");
        var nameCounter = 0;
        var namesLength = names.length;
        for (; nameCounter < namesLength; nameCounter++) {
            if (element.removeEventListener) {
                element.removeEventListener(names[nameCounter], callback, false);
            } else {
                element.detachEvent("on" + names[nameCounter], callback);
            }
        }
    });
    var _removeAllEvents = function () {
        var eventData;
        var eventCounter = 0;
        var eventsLength = _registeredEvents.length;
        for (; eventCounter < eventsLength; eventCounter++) {
            eventData = _registeredEvents[eventCounter];
            _removeEvent(eventData.element, eventData.name, eventData.listener);
        }
        _registeredEvents = [];
    };
    var _emitEvent = function (element, name, direction) {
        if (_listeners.keyframe) {
            _listeners.keyframe.call(_instance, element, name, direction);
        }
    };
    var _reflow = function () {
        var pos = _instance.getScrollTop();
        _maxKeyFrame = 0;
        if (_forceHeight && !_isMobile) {
            body.style.height = "auto";
        }
        _updateDependentKeyFrames();
        if (_forceHeight && !_isMobile) {
            body.style.height = _maxKeyFrame + documentElement.clientHeight + "px";
        }
        if (_isMobile) {
            _instance.setScrollTop(Math.min(_instance.getScrollTop(), _maxKeyFrame));
        } else {
            _instance.setScrollTop(pos, true);
        }
        _forceRender = true;
    };
    var _processConstants = function () {
        var viewportHeight = documentElement.clientHeight;
        var copy = {};
        var prop;
        var value;
        for (prop in _constants) {
            value = _constants[prop];
            if (typeof value === "function") {
                value = value.call(_instance);
            } else {
                if (/p$/.test(value)) {
                    value = (value.slice(0, -1) / 100) * viewportHeight;
                }
            }
            copy[prop] = value;
        }
        return copy;
    };
    var _getDocumentHeight = function () {
        var skrollrBodyHeight = (_skrollrBody && _skrollrBody.offsetHeight) || 0;
        var bodyHeight = Math.max(skrollrBodyHeight, body.scrollHeight, body.offsetHeight, documentElement.scrollHeight, documentElement.offsetHeight, documentElement.clientHeight);
        return bodyHeight - documentElement.clientHeight;
    };
    var _getClass = function (element) {
        var prop = "className";
        if (window.SVGElement && element instanceof window.SVGElement) {
            element = element[prop];
            prop = "baseVal";
        }
        return element[prop];
    };
    var _updateClass = function (element, add, remove) {
        var prop = "className";
        if (window.SVGElement && element instanceof window.SVGElement) {
            element = element[prop];
            prop = "baseVal";
        }
        if (remove === undefined) {
            element[prop] = add;
            return;
        }
        var val = element[prop];
        var classRemoveIndex = 0;
        var removeLength = remove.length;
        for (; classRemoveIndex < removeLength; classRemoveIndex++) {
            val = _untrim(val).replace(_untrim(remove[classRemoveIndex]), " ");
        }
        val = _trim(val);
        var classAddIndex = 0;
        var addLength = add.length;
        for (; classAddIndex < addLength; classAddIndex++) {
            if (_untrim(val).indexOf(_untrim(add[classAddIndex])) === -1) {
                val += " " + add[classAddIndex];
            }
        }
        element[prop] = _trim(val);
    };
    var _trim = function (a) {
        return a.replace(rxTrim, "");
    };
    var _untrim = function (a) {
        return " " + a + " ";
    };
    var _now =
        Date.now ||
        function () {
            return +new Date();
        };
    var _keyFrameComparator = function (a, b) {
        return a.frame - b.frame;
    };
    var _instance;
    var _skrollables;
    var _skrollrBody;
    var _listeners;
    var _forceHeight;
    var _maxKeyFrame = 0;
    var _scale = 1;
    var _constants;
    var _mobileDeceleration;
    var _direction = "down";
    var _lastTop = -1;
    var _lastRenderCall = _now();
    var _lastViewportWidth = 0;
    var _lastViewportHeight = 0;
    var _requestReflow = false;
    var _scrollAnimation;
    var _smoothScrollingEnabled;
    var _smoothScrollingDuration;
    var _smoothScrolling;
    var _forceRender;
    var _skrollableIdCounter = 0;
    var _edgeStrategy;
    var _isMobile = false;
    var _mobileOffset = 0;
    var _translateZ;
    var _registeredEvents = [];
    var _animFrame;
    if (typeof define === "function" && define.amd) {
        define("skrollr", function () {
            return skrollr;
        });
    } else {
        window.skrollr = skrollr;
    }
})(window, document);
(function ($) {
    $.fn.lightGallery = function (options) {
        var defaults = {
                mode: "slide",
                useCSS: true,
                easing: "linear",
                speed: 1000,
                loop: false,
                auto: false,
                pause: 4000,
                escKey: true,
                rel: false,
                lang: { allPhotos: "All photos" },
                exThumbImage: false,
                thumbnail: true,
                caption: false,
                captionLink: false,
                desc: false,
                counter: false,
                controls: true,
                hideControlOnEnd: false,
                mobileSrc: false,
                mobileSrcMaxWidth: 640,
                swipeThreshold: 50,
                vimeoColor: "CCCCCC",
                videoAutoplay: true,
                videoMaxWidth: 855,
                dynamic: false,
                dynamicEl: [],
                onOpen: function () {},
                onSlideBefore: function () {},
                onSlideAfter: function () {},
                onSlideNext: function () {},
                onSlidePrev: function () {},
                onBeforeClose: function () {},
                onCloseAfter: function () {},
            },
            el = $(this),
            $children,
            index,
            lightGalleryOn = false,
            html = '<div id="lightGallery-outer"><div id="lightGallery-Gallery"><div id="lightGallery-slider"></div><a id="lightGallery-close" class="close"></a></div></div>',
            isTouch = document.createTouch !== undefined || "ontouchstart" in window || "onmsgesturechange" in window || navigator.msMaxTouchPoints,
            $gallery,
            $galleryCont,
            $slider,
            $slide,
            $prev,
            $next,
            prevIndex,
            $thumb_cont,
            $thumb,
            windowWidth,
            interval,
            usingThumb = false,
            aTiming = false,
            aSpeed = false;
        var settings = $.extend(true, {}, defaults, options);
        var lightGallery = {
            init: function () {
                el.each(function () {
                    var $this = $(this);
                    if (settings.dynamic == true) {
                        $children = settings.dynamicEl;
                        index = 0;
                        prevIndex = index;
                        setUp.init(index);
                    } else {
                        $children = $(this).children();
                        $children.click(function (e) {
                            if (settings.rel == true && $this.data("rel")) {
                                var rel = $this.data("rel");
                                $children = $('[data-rel="' + rel + '"]').children();
                            } else {
                                $children = $this.children();
                            }
                            e.preventDefault();
                            e.stopPropagation();
                            index = $children.index(this);
                            prevIndex = index;
                            setUp.init(index);
                        });
                    }
                });
            },
        };
        var setUp = {
            init: function () {
                this.start();
                this.build();
            },
            start: function () {
                this.structure();
                this.getWidth();
                this.closeSlide();
            },
            build: function () {
                this.loadContent(index);
                this.addCaption();
                this.addDesc();
                this.counter();
                this.slideTo();
                this.buildThumbnail();
                this.keyPress();
                this.slide(index);
                this.touch();
                this.enableTouch();
                setTimeout(function () {
                    $gallery.addClass("opacity");
                }, 50);
            },
            structure: function () {
                $("body").append(html).addClass("lightGallery");
                $galleryCont = $("#lightGallery-outer");
                $gallery = $("#lightGallery-Gallery");
                $slider = $gallery.find("#lightGallery-slider");
                var slideList = "";
                if (settings.dynamic == true) {
                    for (var i = 0; i < settings.dynamicEl.length; i++) {
                        slideList += '<div class="lightGallery-slide"></div>';
                    }
                } else {
                    $children.each(function () {
                        slideList += '<div class="lightGallery-slide"></div>';
                    });
                }
                $slider.append(slideList);
                $slide = $gallery.find(".lightGallery-slide");
            },
            closeSlide: function () {
                var $this = this;
                $("#lightGallery-close").bind("click touchend", function () {
                    $this.destroy();
                });
            },
            getWidth: function () {
                var resizeWindow = function () {
                    windowWidth = $(window).width();
                };
                $(window).bind("resize.lightGallery", resizeWindow());
            },
            doCss: function () {
                var support = function () {
                    var transition = ["transition", "MozTransition", "WebkitTransition", "OTransition", "msTransition", "KhtmlTransition"];
                    var root = document.documentElement;
                    for (var i = 0; i < transition.length; i++) {
                        if (transition[i] in root.style) {
                            return true;
                        }
                    }
                };
                if (settings.useCSS && support()) {
                    return true;
                }
                return false;
            },
            enableTouch: function () {
                var $this = this;
                if (isTouch) {
                    var startCoords = {},
                        endCoords = {};
                    $("body").on("touchstart.lightGallery", function (e) {
                        endCoords = e.originalEvent.targetTouches[0];
                        startCoords.pageX = e.originalEvent.targetTouches[0].pageX;
                        startCoords.pageY = e.originalEvent.targetTouches[0].pageY;
                    });
                    $("body").on("touchmove.lightGallery", function (e) {
                        var orig = e.originalEvent;
                        endCoords = orig.targetTouches[0];
                        e.preventDefault();
                    });
                    $("body").on("touchend.lightGallery", function (e) {
                        var distance = endCoords.pageX - startCoords.pageX,
                            swipeThreshold = settings.swipeThreshold;
                        if (distance >= swipeThreshold) {
                            $this.prevSlide();
                            clearInterval(interval);
                        } else {
                            if (distance <= -swipeThreshold) {
                                $this.nextSlide();
                                clearInterval(interval);
                            }
                        }
                    });
                }
            },
            touch: function () {
                var xStart, xEnd;
                var $this = this;
                $(".lightGallery").bind("mousedown", function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    xStart = e.pageX;
                });
                $(".lightGallery").bind("mouseup", function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    xEnd = e.pageX;
                    if (xEnd - xStart > 20) {
                        $this.prevSlide();
                    } else {
                        if (xStart - xEnd > 20) {
                            $this.nextSlide();
                        }
                    }
                });
            },
            isVideo: function (src) {
                var youtube = src.match(/youtube\.com\/watch\?v=([a-zA-Z0-9\-_]+)/);
                var vimeo = src.match(/vimeo\.com\/([0-9]*)/);
                if (youtube || vimeo) {
                    return true;
                }
            },
            loadVideo: function (src, a, _id) {
                var youtube = src.match(/watch\?v=([a-zA-Z0-9\-_]+)/);
                var vimeo = src.match(/vimeo\.com\/([0-9]*)/);
                var video = "";
                if (youtube) {
                    if (settings.videoAutoplay === true && a === true) {
                        a = "?autoplay=1&rel=0&wmode=opaque";
                    } else {
                        a = "?wmode=opaque";
                    }
                    video = '<iframe id="video' + _id + '" width="560" height="315" src="//www.youtube.com/embed/' + youtube[1] + a + '" frameborder="0" allowfullscreen></iframe>';
                } else {
                    if (vimeo) {
                        if (settings.videoAutoplay === true && a === true) {
                            a = "autoplay=1&amp;";
                        } else {
                            a = "";
                        }
                        video =
                            '<iframe id="video' +
                            _id +
                            '" width="560" height="315"  src="http://player.vimeo.com/video/' +
                            vimeo[1] +
                            "?" +
                            a +
                            "byline=0&amp;portrait=0&amp;color=" +
                            settings.vimeoColor +
                            '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                    }
                }
                return '<div class="video_cont" style="max-width:' + settings.videoMaxWidth + 'px !important;"><div class="video">' + video + "</div></div>";
            },
            loadContent: function (index) {
                var $this = this;
                var i,
                    j,
                    ob,
                    l = $children.length - index;
                var src;
                $this.autoStart();
                if (settings.mobileSrc === true && windowWidth <= settings.mobileSrcMaxWidth) {
                    if (settings.dynamic == true) {
                        src = settings.dynamicEl[0]["mobileSrc"];
                    } else {
                        src = $children.eq(index).attr("data-responsive-src");
                    }
                } else {
                    if (settings.dynamic == true) {
                        src = settings.dynamicEl[0]["src"];
                    } else {
                        src = $children.eq(index).attr("data-src");
                    }
                }
                if (!$this.isVideo(src)) {
                    $slide.eq(index).prepend('<img src="' + src + '" />');
                    ob = $("img");
                } else {
                    $slide.eq(index).prepend($this.loadVideo(src, true, index));
                    ob = $("iframe");
                    if (settings.auto && settings.videoAutoplay === true) {
                        clearInterval(interval);
                    }
                }
                if ($children.length > 1) {
                    $slide
                        .eq(index)
                        .find(ob)
                        .on("load error", function () {
                            for (i = 0; i <= index - 1; i++) {
                                var src;
                                if (settings.mobileSrc === true && windowWidth <= settings.mobileSrcMaxWidth) {
                                    if (settings.dynamic == true) {
                                        src = settings.dynamicEl[index - i - 1]["mobileSrc"];
                                    } else {
                                        src = $children.eq(index - i - 1).attr("data-responsive-src");
                                    }
                                } else {
                                    if (settings.dynamic == true) {
                                        src = settings.dynamicEl[index - i - 1]["src"];
                                    } else {
                                        src = $children.eq(index - i - 1).attr("data-src");
                                    }
                                }
                                if (!$this.isVideo(src)) {
                                    $slide.eq(index - i - 1).prepend('<img src="' + src + '" />');
                                } else {
                                    $slide.eq(index - i - 1).prepend($this.loadVideo(src, false, index - i - 1));
                                }
                            }
                            for (j = 1; j < l; j++) {
                                var src;
                                if (settings.mobileSrc === true && windowWidth <= settings.mobileSrcMaxWidth) {
                                    if (settings.dynamic == true) {
                                        src = settings.dynamicEl[index + j]["mobileSrc"];
                                    } else {
                                        src = $children.eq(index + j).attr("data-responsive-src");
                                    }
                                } else {
                                    if (settings.dynamic == true) {
                                        src = settings.dynamicEl[index + j]["src"];
                                    } else {
                                        src = $children.eq(index + j).attr("data-src");
                                    }
                                }
                                if (!$this.isVideo(src)) {
                                    $slide.eq(index + j).prepend('<img src="' + src + '" />');
                                } else {
                                    $slide.eq(index + j).prepend($this.loadVideo(src, false, index + j));
                                }
                            }
                        });
                }
            },
            addCaption: function () {
                if (settings.caption === true) {
                    var i,
                        title = false;
                    for (i = 0; i < $children.length; i++) {
                        if (settings.dynamic == true) {
                            title = settings.dynamicEl[i]["caption"];
                        } else {
                            title = $children.eq(i).attr("data-title");
                        }
                        if (typeof title == "undefined" || title == null) {
                            title = "image " + i + "";
                        }
                        if (settings.captionLink === true) {
                            var link = $children.eq(i).attr("data-link");
                            if (typeof link !== "undefined" && link !== "") {
                                link = link;
                            } else {
                                link = "#";
                            }
                            $slide.eq(i).append('<div class="info group"><a href="' + link + '" class="title">' + title + "</a></div>");
                        } else {
                            $slide.eq(i).append('<div class="info group"><span class="title">' + title + "</span></div>");
                        }
                    }
                }
            },
            addDesc: function () {
                if (settings.desc === true) {
                    var i,
                        description = false;
                    for (i = 0; i < $children.length; i++) {
                        if (settings.dynamic == true) {
                            description = settings.dynamicEl[i]["desc"];
                        } else {
                            description = $children.eq(i).attr("data-desc");
                        }
                        if (typeof description == "undefined" || description == null) {
                            description = "image " + i + "";
                        }
                        if (settings.caption === false) {
                            $slide.eq(i).append('<div class="info group"><span class="desc">' + description + "</span></div>");
                        } else {
                            $slide
                                .eq(i)
                                .find(".info")
                                .append('<span class="desc">' + description + "</span>");
                        }
                    }
                }
            },
            counter: function () {
                if (settings.counter === true) {
                    var slideCount = $("#lightGallery-slider > div").length;
                    $gallery.append("<div id='lightGallery_counter'><span id='lightGallery_counter_current'></span> / <span id='lightGallery_counter_all'>" + slideCount + "</span></div>");
                }
            },
            buildThumbnail: function () {
                if (settings.thumbnail === true && $children.length > 1) {
                    var $this = this;
                    $gallery.append('<div class="thumb_cont"><div class="thumb_info"><span class="close ib"><i class="bUi-iCn-rMv-16" aria-hidden="true"></i></span></div><div class="thumb_inner"></div></div>');
                    $thumb_cont = $gallery.find(".thumb_cont");
                    $prev.after('<a class="cLthumb"></a>');
                    $gallery.find(".cLthumb").bind("click touchend", function () {
                        $thumb_cont.addClass("open");
                        if ($this.doCss() && settings.mode === "slide") {
                            $slide.eq(index).prevAll().removeClass("nextSlide").addClass("prevSlide");
                            $slide.eq(index).nextAll().removeClass("prevSlide").addClass("nextSlide");
                        }
                    });
                    $gallery.find(".close").bind("click touchend", function () {
                        $thumb_cont.removeClass("open");
                    });
                    var thumbInfo = $gallery.find(".thumb_info");
                    var $thumb_inner = $gallery.find(".thumb_inner");
                    var thumbList = "";
                    var thumbImg;
                    if (settings.dynamic == true) {
                        for (var i = 0; i < settings.dynamicEl.length; i++) {
                            thumbImg = settings.dynamicEl[i]["thumb"];
                            thumbList += '<div class="thumb"><img src="' + thumbImg + '" /></div>';
                        }
                    } else {
                        $children.each(function () {
                            if (settings.exThumbImage === false || typeof $(this).attr(settings.exThumbImage) == "undefined" || $(this).attr(settings.exThumbImage) == null) {
                                thumbImg = $(this).find("img").attr("src");
                            } else {
                                thumbImg = $(this).attr(settings.exThumbImage);
                            }
                            thumbList += '<div class="thumb"><img src="' + thumbImg + '" /></div>';
                        });
                    }
                    $thumb_inner.append(thumbList);
                    $thumb = $thumb_inner.find(".thumb");
                    $thumb.bind("click touchend", function () {
                        usingThumb = true;
                        var index = $(this).index();
                        $thumb.removeClass("active");
                        $(this).addClass("active");
                        $this.slide(index);
                        clearInterval(interval);
                    });
                    thumbInfo.prepend('<span class="ib count">' + settings.lang.allPhotos + " (" + $thumb.length + ")</span>");
                }
            },
            slideTo: function () {
                var $this = this;
                if (settings.controls === true && $children.length > 1) {
                    $gallery.append('<div id="lightGallery-action"><a id="lightGallery-prev"></a><a id="lightGallery-next"></a></div>');
                    $prev = $gallery.find("#lightGallery-prev");
                    $next = $gallery.find("#lightGallery-next");
                    $prev.bind("click", function () {
                        $this.prevSlide();
                        clearInterval(interval);
                    });
                    $next.bind("click", function () {
                        $this.nextSlide();
                        clearInterval(interval);
                    });
                }
            },
            autoStart: function () {
                var $this = this;
                if (settings.auto === true) {
                    interval = setInterval(function () {
                        if (index + 1 < $children.length) {
                            index = index;
                        } else {
                            index = -1;
                        }
                        index++;
                        $this.slide(index);
                    }, settings.pause);
                }
            },
            keyPress: function () {
                var $this = this;
                $(window).bind("keyup.lightGallery", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (e.keyCode === 37) {
                        $this.prevSlide();
                        clearInterval(interval);
                    }
                    if (e.keyCode === 38 && settings.thumbnail === true) {
                        if (!$thumb_cont.hasClass("open")) {
                            if ($this.doCss() && settings.mode === "slide") {
                                $slide.eq(index).prevAll().removeClass("nextSlide").addClass("prevSlide");
                                $slide.eq(index).nextAll().removeClass("prevSlide").addClass("nextSlide");
                            }
                            $thumb_cont.addClass("open");
                        }
                    } else {
                        if (e.keyCode === 39) {
                            $this.nextSlide();
                            clearInterval(interval);
                        }
                    }
                    if (e.keyCode === 40 && settings.thumbnail === true) {
                        if ($thumb_cont.hasClass("open")) {
                            $thumb_cont.removeClass("open");
                        }
                    } else {
                        if (settings.escKey === true && e.keyCode === 27) {
                            if (settings.thumbnail === true && $thumb_cont.hasClass("open")) {
                                $thumb_cont.removeClass("open");
                            } else {
                                $this.destroy();
                            }
                        }
                    }
                });
            },
            nextSlide: function () {
                var $this = this;
                index = $slide.index($slide.eq(prevIndex));
                if (index + 1 < $children.length) {
                    index++;
                    $this.slide(index);
                } else {
                    if (settings.loop) {
                        index = 0;
                        $this.slide(index);
                    } else {
                        if (settings.mode === "fade" && settings.thumbnail === true && $children.length > 1) {
                            $thumb_cont.addClass("open");
                        }
                    }
                }
                settings.onSlideNext.call(this);
            },
            prevSlide: function () {
                var $this = this;
                index = $slide.index($slide.eq(prevIndex));
                if (index > 0) {
                    index--;
                    $this.slide(index);
                } else {
                    if (settings.loop) {
                        index = $children.length - 1;
                        $this.slide(index);
                    } else {
                        if (settings.mode === "fade" && settings.thumbnail === true && $children.length > 1) {
                            $thumb_cont.addClass("open");
                        }
                    }
                }
                settings.onSlidePrev.call(this);
            },
            slide: function (index) {
                if (lightGalleryOn) {
                    if (!$slider.hasClass("on")) {
                        $slider.addClass("on");
                    }
                    if (this.doCss() && settings.speed !== "") {
                        if (!$slider.hasClass("speed")) {
                            $slider.addClass("speed");
                        }
                        if (aSpeed === false) {
                            $slider.css("transition-duration", settings.speed + "ms");
                            aSpeed = true;
                        }
                    }
                    if (this.doCss() && settings.easing !== "") {
                        if (!$slider.hasClass("timing")) {
                            $slider.addClass("timing");
                        }
                        if (aTiming === false) {
                            $slider.css("transition-timing-function", settings.easing);
                            aTiming = true;
                        }
                    }
                    settings.onSlideBefore.call(this);
                }
                if (settings.mode === "slide") {
                    if (this.doCss() && !$slider.hasClass("slide")) {
                        $slider.addClass("slide");
                    }
                    if (!this.doCss() && !lightGalleryOn) {
                        $slider.css({ left: -index * 100 + "%" });
                    } else {
                        if (!this.doCss() && lightGalleryOn) {
                            $slider.animate({ left: -index * 100 + "%" }, settings.speed, settings.easing);
                        }
                    }
                } else {
                    if (settings.mode === "fade") {
                        if (this.doCss() && !$slider.hasClass("fadeM")) {
                            $slider.addClass("fadeM");
                        } else {
                            if (!this.doCss() && !$slider.hasClass("animate")) {
                                $slider.addClass("animate");
                            }
                        }
                        if (!this.doCss() && !lightGalleryOn) {
                            $slide.fadeOut(100);
                            $slide.eq(index).fadeIn(100);
                        } else {
                            if (!this.doCss() && lightGalleryOn) {
                                $slide.eq(prevIndex).fadeOut(settings.speed, settings.easing);
                                $slide.eq(index).fadeIn(settings.speed, settings.easing);
                            }
                        }
                    }
                }
                if (index + 1 >= $children.length && settings.auto && settings.loop === false) {
                    clearInterval(interval);
                }
                $slide.eq(prevIndex).removeClass("current");
                $slide.eq(index).addClass("current");
                if (this.doCss() && settings.mode === "slide") {
                    if (usingThumb === false) {
                        $(".prevSlide").removeClass("prevSlide");
                        $(".nextSlide").removeClass("nextSlide");
                        $slide.eq(index - 1).addClass("prevSlide");
                        $slide.eq(index + 1).addClass("nextSlide");
                    } else {
                        $slide.eq(index).prevAll().removeClass("nextSlide").addClass("prevSlide");
                        $slide.eq(index).nextAll().removeClass("prevSlide").addClass("nextSlide");
                    }
                }
                if (settings.thumbnail === true && $children.length > 1) {
                    $thumb.removeClass("active");
                    $thumb.eq(index).addClass("active");
                }
                if (settings.controls && settings.hideControlOnEnd && settings.loop === false) {
                    if (index === 0) {
                        $prev.addClass("disabled");
                    } else {
                        if (index === $children.length - 1) {
                            $next.addClass("disabled");
                        } else {
                            $prev.add($next).removeClass("disabled");
                        }
                    }
                }
                prevIndex = index;
                lightGalleryOn === false ? settings.onOpen.call(this) : settings.onSlideAfter.call(this);
                lightGalleryOn = true;
                usingThumb = false;
                if (settings.counter) {
                    $("#lightGallery_counter_current").text(index + 1);
                }
            },
            destroy: function () {
                settings.onBeforeClose.call(this);
                lightGalleryOn = false;
                aTiming = false;
                aSpeed = false;
                usingThumb = false;
                clearInterval(interval);
                $(".lightGallery").off("mousedown mouseup");
                $("body").off("touchstart.lightGallery touchmove.lightGallery touchend.lightGallery");
                $(window).off("resize.lightGallery keyup.lightGallery");
                $gallery.addClass("fadeM");
                setTimeout(function () {
                    $galleryCont.remove();
                    $("body").removeClass("lightGallery");
                }, 500);
                settings.onCloseAfter.call(this);
            },
        };
        lightGallery.init();
        return this;
    };
})(jQuery);
(function ($) {
    var $_count_id = 0;
    $.fn.imageMask = function (_mask, _callback) {
        if (_mask == undefined) {
            console.error("imageMask: undefined mask");
            return false;
        }
        if (!this.is("img")) {
            console.error("imageMask: jQuery object MUST be an img element");
            return false;
        }
        if (_callback != undefined && !$.isFunction(_callback)) {
            console.error("imageMask: callback MUST be function");
            return false;
        }
        var maskObj = null;
        if (_mask.src) {
            maskObj = _mask;
        } else {
            maskObj = new Image();
            maskObj.src = _mask;
        }
        var obj = this;
        obj.css("visibility", "hidden");
        $(maskObj).load(function () {
            var $maskData = null;
            obj.each(function () {
                var $image = $(this),
                    $canvasObj = null;
                $canvasObj = createCanvas(this, maskObj)[0];
                var ctx = $canvasObj.getContext("2d");
                if ($maskData == null) {
                    $maskData = get_maskData($canvasObj, ctx, maskObj);
                }
                var img = new Image();
                img.src = $(this).attr("src");
                $(img).load(function () {
                    drawImg($canvasObj, ctx, img);
                    applyMask($canvasObj, ctx, $maskData);
                    $image.remove();
                    if ($.isFunction(_callback)) {
                        _callback($canvasObj);
                    }
                });
            });
        });
        return this;
    };
    function createCanvas(img, mask) {
        img = $(img);
        var id;
        if (img.attr("id")) {
            id = img.attr("id");
        } else {
            id = $_count_id++;
        }
        id = "imageMask_" + id + "_canvas";
        return $("<canvas>")
            .attr({ id: id, class: img.attr("class"), style: img.attr("style"), width: mask.width, height: mask.height })
            .css("visibility", "")
            .insertAfter(img);
    }
    function get_maskData(canvasObj, ctx, mask) {
        ctx.drawImage(mask, 0, 0);
        var maskData = ctx.getImageData(0, 0, canvasObj.width, canvasObj.height);
        ctx.clearRect(0, 0, canvasObj.width, canvasObj.height);
        return maskData;
    }
    function drawImg(canvasObj, ctx, img) {
        var ratio = 1;
        if (img.width > img.height) {
            ratio = canvasObj.height / img.height;
        } else {
            ratio = canvasObj.width / img.width;
        }
        ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0, img.width * ratio, img.height * ratio);
    }
    function applyMask(canvasObj, ctx, maskData) {
        var imgData = ctx.getImageData(0, 0, canvasObj.width, canvasObj.height);
        for (var i = 0; i < imgData.data.length; i += 4) {
            imgData.data[i + 3] = maskData.data[i + 3];
        }
        ctx.putImageData(imgData, 0, 0);
    }
})(jQuery);
(function () {
    var $;
    $ = jQuery;
    $.fn.initPageSlider = function () {
        var $pagination, options, page_slider;
        $pagination = $("#page-slider").find(".sequence-pagination");
        options = { autoPlay: true, autoPlayDelay: 2000, pauseOnHover: true, pagination: $pagination };
        return (page_slider = $("#page-slider").sequence(options).data("page_slider"));
    };
    $.fn.initNewsWidgetSlider = function () {
        var $pagination, news_slider, options;
        $pagination = $("#news-widget-slider").find(".sequence-pagination");
        options = { autoPlay: true, autoPlayDelay: 3000, pauseOnHover: true, pagination: $pagination };
        return (news_slider = $("#news-widget-slider").sequence(options).data("news_slider"));
    };
    $.fn.initOffersWidgetSlider = function () {
        var $pagination, offers_slider, options;
        $pagination = $("#offers-widget-slider").find(".sequence-pagination");
        options = { autoPlay: true, autoPlayDelay: 3000, pauseOnHover: true, pagination: $pagination };
        return (offers_slider = $("#offers-widget-slider").sequence(options).data("offers_slider"));
    };
    $.fn.initMustSeeSlider = function () {
        var $pagination, mustsee_slider, options;
        $pagination = $("#must-see-slider").find(".sequence-pagination");
        options = { autoPlay: true, autoPlayDelay: 3000, pauseOnHover: true, pagination: $pagination };
        mustsee_slider = $("#must-see-slider").find(".slider-holder").sequence(options).data("mustsee_slider");
        return $("#must-see-slider .sequence-pagination li").on("hover", function () {
            return $(this).trigger("click");
        });
    };
    $.fn.initSkrollr = function () {
        var s;
        if ($(window).width() > 960) {
            return (s = skrollr.init({ forceHeight: false }));
        }
    };
    $.fn.singleGalleryCarousel = function () {
        return $("#single-gallery-carousel").sly({
            horizontal: 1,
            itemSelector: "li",
            itemNav: "basic",
            touchDragging: 1,
            elasticBounds: 1,
            scrollBy: 1,
            speed: 800,
            smart: 1,
            prevPage: ".gallery-carousel-prev",
            nextPage: ".gallery-carousel-next",
        });
    };
    $.fn.contactFormGroups = function () {
        var $form;
        $form = $(".contact-form");
        $(".form-field:eq(0), .form-field:eq(1), .form-field:eq(2)").wrapAll('<ul class="contact-block-left"></ul>');
        return $(".form-field:eq(3), .form-field:eq(4)").wrapAll('<ul class="contact-block-right"></ul>');
    };

    $.fn.textScroller = function () {
        var $frame, $scrollbar, $slidee;
        $frame = $(".text-scroller").height();
        $slidee = $(".text-scroller").find(".slidee").height();
        if ($frame === $slidee) {
            $(".text-scroller").find(".scrollbar").addClass("disabled");
        }
        $scrollbar = $(".text-scroller").find(".scrollbar");
        $(".text-scroller").sly({ touchDragging: 1, elasticBounds: 1, scrollBy: 80, speed: 300, scrollBar: $scrollbar, dragHandle: 1 });
        return $(".text-scroller").sly("on", "load", function () {
            return $(".text-scroller").sly("reload");
        });
    };
    $.fn.fixEqualHeights = function () {
        $(".rooms-list .room-excerpt, .rooms-list .room-content").equalHeightColumns();
        $(".rooms-list .read-more").equalHeightColumns();
        $(".facilities-list .facility-excerpt, .facilities-list .facility-content").equalHeightColumns();
        return $("#stay, #dine").equalHeightColumns();
    };

    $.fn.initPhotoGallery = function () {
        var $button;
        $button = $(".gallery-item");
        $button.on("click", function (event) {
            var $gallery, $id;
            event.preventDefault();
            $gallery = $(".gallery-container");
            $id = $(this).attr("data-id");
            return $.ajax({ url: genius_theme.ajax_url, type: "get", data: { action: "genius_theme_photo_gallery", id: $id } })
                .done(function (data) {
                    return $gallery.html(data);
                })
                .then(function () {
                    return $(".galleries-list").fadeOut(500, function () {
                        return $gallery.fadeIn(500);
                    });
                });
        });
        return $(document).on("click", "#close-gallery", function () {
            return $(".gallery-container").fadeOut(500, function () {
                return $(".galleries-list").fadeIn(500);
            });
        });
    };
    $.fn.ieImageMasks = function () {
        $(".square-position-1 img").imageMask(genius_theme.theme_uri + "/images/slider-mask-1.png");
        $(".square-position-2 img").imageMask(genius_theme.theme_uri + "/images/slider-mask-2.png");
        $(".square-position-3 img").imageMask(genius_theme.theme_uri + "/images/slider-mask-3.png");
        $(".featured-squares.small img").imageMask(genius_theme.theme_uri + "/images/small-mask.png");
        return $(".featured-squares.tiny img").imageMask(genius_theme.theme_uri + "/images/tiny-mask.png");
    };
    $(document).ready(function () {
        $(document).contactFormGroups();
        $(document).initPageSlider();
        $(document).initMustSeeSlider();
        $(document).initNewsWidgetSlider();
        $(document).initOffersWidgetSlider();
        $(document).initSkrollr();
        $(document).initPhotoGallery();
        $(document).textScroller();
        $(document).fixEqualHeights();
        $(document).singleGalleryCarousel();
        $(document).initPhotoGallery();
        $("#arrival").datepicker({
            dateFormat: "dd/mm/yy",
            onClose: function (selectedDate) {
                return $("#departure").datepicker("option", "minDate", selectedDate);
            },
        });
        $("#departure").datepicker({
            dateFormat: "dd/mm/yy",
            onClose: function (selectedDate) {
                return $("#arrival").datepicker("option", "maxDate", selectedDate);
            },
        });
        $(".gallery-carousel-items").lightGallery({ caption: true, hideControlOnEnd: true, exThumbImage: "data-exthumbimage" });
        $("#booking-form select").customSelect();
        $("#document-header").sticky();
        return $(window).load(function () {
            if ($("html").hasClass("ie9") || $("html").hasClass("ie10") || $("html").hasClass("ie11")) {
                return $(document).ieImageMasks();
            }
        });
    });
}.call(this));
