

(function($, window, google, undefined) {
    var html_dropdown, html_ullist, Maplace;
    html_dropdown = {
        activateCurrent: function(index) {
            this.html_element.find("select").val(index)
        },
        getHtml: function() {
            var self = this,
                html = "",
                title, a;
            if (this.ln > 1) {
                html += '<select class="dropdown controls ' + this.o.controls_cssclass + '">';
                if (this.ShowOnMenu(this.view_all_key)) {
                    html += '<option value="' + this.view_all_key + '">' + this.o.view_all_text + "</option>"
                }
                for (a = 0; a < this.ln; a += 1) {
                    if (this.ShowOnMenu(a)) {
                        html += '<option value="' + (a + 1) + '">' + (this.o.locations[a].title || ("#" + (a + 1))) + "</option>"
                    }
                }
                html += "</select>";
                html = $(html).bind("change", function() {
                    self.ViewOnMap(this.value)
                })
            }
            title = this.o.controls_title;
            if (this.o.controls_title) {
                title = $('<div class="controls_title"></div>').css(this.o.controls_applycss ? {
                    fontWeight: "bold",
                    fontSize: this.o.controls_on_map ? "12px" : "inherit",
                    padding: "3px 10px 5px 0"
                } : {}).append(this.o.controls_title)
            }
            this.html_element = $('<div class="wrap_controls"></div>').append(title).append(html);
            return this.html_element
        }
    };
    html_ullist = {
        html_a: function(i, hash, ttl) {
            var self = this,
                index = hash || (i + 1),
                title = ttl || this.o.locations[i].title,
                el_a = $('<a data-load="' + index + '" id="ullist_a_' + index + '" href="#' + index + '" title="' + title + '"><span>' + (title || ("#" + (i + 1))) + "</span></a>");
            el_a.css(this.o.controls_applycss ? {
                color: "#666",
                display: "block",
                padding: "5px",
                fontSize: this.o.controls_on_map ? "12px" : "inherit",
                textDecoration: "none"
            } : {});
            el_a.on("click", function(e) {
                e.preventDefault();
                var i = $(this).attr("data-load");
                self.ViewOnMap(i)
            });
            return el_a
        },
        activateCurrent: function(index) {
            this.html_element.find("li").removeClass("active");
            this.html_element.find("#ullist_a_" + index).parent().addClass("active")
        },
        getHtml: function() {
            var html = $("<ul class='ullist controls " + this.o.controls_cssclass + "'></ul>").css(this.o.controls_applycss ? {
                    margin: 0,
                    padding: 0,
                    listStyleType: "none"
                } : {}),
                title, a;
            if (this.ShowOnMenu(this.view_all_key)) {
                html.append($("<li></li>").append(html_ullist.html_a.call(this, false, this.view_all_key, this.o.view_all_text)))
            }
            for (a = 0; a < this.ln; a++) {
                if (this.ShowOnMenu(a)) {
                    html.append($("<li></li>").append(html_ullist.html_a.call(this, a)))
                }
            }
            title = this.o.controls_title;
            if (this.o.controls_title) {
                title = $('<div class="controls_title"></div>').css(this.o.controls_applycss ? {
                    fontWeight: "bold",
                    padding: "3px 10px 5px 0",
                    fontSize: this.o.controls_on_map ? "12px" : "inherit"
                } : {}).append(this.o.controls_title)
            }
            this.html_element = $('<div class="wrap_controls"></div>').append(title).append(html);
            return this.html_element
        }
    };
    Maplace = (function() {
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
                map_options: {
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    zoom: 1
                },
                stroke_options: {
                    strokeColor: "#0000FF",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#0000FF",
                    fillOpacity: 0.4
                },
                directions_options: {
                    travelMode: google.maps.TravelMode.DRIVING,
                    unitSystem: google.maps.UnitSystem.METRIC,
                    optimizeWaypoints: false,
                    provideRouteAlternatives: false,
                    avoidHighways: false,
                    avoidTolls: false
                },
                styles: {},
                fusion_options: {},
                directions_panel: null,
                draggable: false,
                show_infowindows: true,
                show_markers: true,
                infowindow_type: "bubble",
                listeners: {},
                beforeViewAll: function() {},
                afterViewAll: function() {},
                beforeShow: function(index, location, marker) {},
                afterShow: function(index, location, marker) {},
                afterCreateMarker: function(index, location, marker) {},
                beforeCloseInfowindow: function(index, location) {},
                afterCloseInfowindow: function(index, location) {},
                beforeOpenInfowindow: function(index, location, marker) {},
                afterOpenInfowindow: function(index, location, marker) {},
                afterRoute: function(distance, status, result) {},
                onPolylineClick: function(obj) {}
            };
            this.AddControl("dropdown", html_dropdown);
            this.AddControl("list", html_ullist);
            $.extend(true, this.o, args)
        }
        Maplace.prototype.controls = {};
        Maplace.prototype.create_objMap = function() {
            var self = this,
                count = 0,
                i;
            for (i in this.o.styles) {
                if (this.o.styles.hasOwnProperty(i)) {
                    if (count === 0) {
                        this.o.map_options.mapTypeControlOptions = {
                            mapTypeIds: [google.maps.MapTypeId.ROADMAP]
                        }
                    }
                    count++;
                    this.o.map_options.mapTypeControlOptions.mapTypeIds.push("map_style_" + count)
                }
            }
            if (!this.loaded) {
                try {
                    this.map_div.css({
                        position: "relative",
                        overflow: "hidden"
                    });
                    this.canvas_map = $("<div>").addClass("canvas_map").css({
                        width: "100%",
                        height: "100%"
                    }).appendTo(this.map_div);
                    this.oMap = new google.maps.Map(this.canvas_map.get(0), this.o.map_options)
                } catch (err) {
                    this.errors.push(err.toString())
                }
            } else {
                self.oMap.setOptions(this.o.map_options)
            }
            count = 0;
            for (i in this.o.styles) {
                if (this.o.styles.hasOwnProperty(i)) {
                    count++;
                    this.oMap.mapTypes.set("map_style_" + count, new google.maps.StyledMapType(this.o.styles[i], {
                        name: i
                    }));
                    this.oMap.setMapTypeId("map_style_" + count)
                }
            }
            this.debug("01")
        };
        Maplace.prototype.add_markers_to_objMap = function() {
            var a, type = this.o.type || "marker";
            switch (type) {
                case "marker":
                    for (a = 0; a < this.ln; a++) {
                        this.create.marker.call(this, a)
                    }
                    break;
                default:
                    this.create[type].apply(this);
                    break
            }
        };
        Maplace.prototype.create = {
            marker: function(index) {
                var self = this,
                    point = this.o.locations[index],
                    html = point.html || "",
                    marker, a, point_infow, image_w, image_h, latlng = new google.maps.LatLng(point.lat, point.lon),
                    orig_visible = point.visible === false ? false : true;
                $.extend(point, {
                    position: latlng,
                    map: this.oMap,
                    zIndex: 10000,
                    visible: (this.o.show_markers === false ? false : orig_visible)
                });
                if (point.image) {
                    image_w = point.image_w || 32;
                    image_h = point.image_h || 32;
                    $.extend(point, {
                        icon: new google.maps.MarkerImage(point.image, new google.maps.Size(image_w, image_h), new google.maps.Point(0, 0), new google.maps.Point(image_w / 2, image_h / 2))
                    })
                }
                marker = new google.maps.Marker(point);
                a = google.maps.event.addListener(marker, "click", function() {
                    self.o.beforeShow(index, point, marker);
                    point_infow = point.show_infowindows === false ? false : true;
                    if (self.o.show_infowindows && point_infow) {
                        self.open_infowindow(index, marker)
                    }
                    self.oMap.panTo(latlng);
                    point.zoom && self.oMap.setZoom(point.zoom);
                    if (self.current_control && self.o.generate_controls && self.current_control.activateCurrent) {
                        self.current_control.activateCurrent.call(self, index + 1)
                    }
                    self.current_index = index;
                    self.o.afterShow(index, point, marker)
                });
                this.oBounds.extend(latlng);
                this.markers.push(marker);
                this.o.afterCreateMarker(index, point, marker);
                point.visible = orig_visible;
                return marker
            },
            polyline: function() {
                var self = this,
                    a, latlng, path = [];
                for (a = 0; a < this.ln; a++) {
                    latlng = new google.maps.LatLng(this.o.locations[a].lat, this.o.locations[a].lon);
                    path.push(latlng);
                    this.create.marker.call(this, a)
                }
                $.extend(this.o.stroke_options, {
                    path: path,
                    map: this.oMap
                });
                this.Polyline ? this.Polyline.setOptions(this.o.stroke_options) : this.Polyline = new google.maps.Polyline(this.o.stroke_options)
            },
            polygon: function() {
                var self = this,
                    a, latlng, path = [];
                for (a = 0; a < this.ln; a++) {
                    latlng = new google.maps.LatLng(this.o.locations[a].lat, this.o.locations[a].lon);
                    path.push(latlng);
                    this.create.marker.call(this, a)
                }
                $.extend(this.o.stroke_options, {
                    paths: path,
                    editable: this.o.draggable,
                    map: this.oMap
                });
                this.Polygon ? this.Polygon.setOptions(this.o.stroke_options) : this.Polygon = new google.maps.Polygon(this.o.stroke_options);
                google.maps.event.addListener(this.Polygon, "click", function(obj) {
                    self.o.onPolylineClick(obj)
                })
            },
            fusion: function() {
                $.extend(this.o.fusion_options, {
                    styles: [this.o.stroke_options],
                    map: this.oMap
                });
                this.Fusion ? this.Fusion.setOptions(this.o.fusion_options) : this.Fusion = new google.maps.FusionTablesLayer(this.o.fusion_options)
            },
            directions: function() {
                var self = this,
                    a, stopover, latlng, origin, destination, waypoints = [],
                    distance = 0;
                for (a = 0; a < this.ln; a++) {
                    latlng = new google.maps.LatLng(this.o.locations[a].lat, this.o.locations[a].lon);
                    if (a === 0) {
                        origin = latlng
                    } else {
                        if (a === (this.ln - 1)) {
                            destination = latlng
                        } else {
                            stopover = this.o.locations[a].stopover === true ? true : false;
                            waypoints.push({
                                location: latlng,
                                stopover: stopover
                            })
                        }
                    }
                    this.create.marker.call(this, a)
                }
                $.extend(this.o.directions_options, {
                    origin: origin,
                    destination: destination,
                    waypoints: waypoints
                });
                this.directionsService || (this.directionsService = new google.maps.DirectionsService());
                this.directionsDisplay ? this.directionsDisplay.setOptions({
                    draggable: this.o.draggable
                }) : this.directionsDisplay = new google.maps.DirectionsRenderer({
                    draggable: this.o.draggable
                });
                this.directionsDisplay.setMap(this.oMap);
                if (this.o.directions_panel) {
                    this.o.directions_panel = $(this.o.directions_panel);
                    this.directionsDisplay.setPanel(this.o.directions_panel.get(0))
                }
                if (this.o.draggable) {
                    google.maps.event.addListener(this.directionsDisplay, "directions_changed", function() {
                        distance = self.compute_distance(self.directionsDisplay.directions);
                        self.o.afterRoute(distance)
                    })
                }
                this.directionsService.route(this.o.directions_options, function(result, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        distance = self.compute_distance(result);
                        self.directionsDisplay.setDirections(result)
                    }
                    self.o.afterRoute(distance, status, result)
                })
            }
        };
        Maplace.prototype.compute_distance = function(result) {
            var total = 0,
                i, myroute = result.routes[0],
                rlen = myroute.legs.length;
            for (i = 0; i < rlen; i++) {
                total += myroute.legs[i].distance.value
            }
            return total
        };
        Maplace.prototype.type_to_open = {
            bubble: function(location) {
                this.infowindow = new google.maps.InfoWindow({
                    content: location.html || ""
                })
            }
        };
        Maplace.prototype.open_infowindow = function(index, marker) {
            this.CloseInfoWindow();
            var point = this.o.locations[index],
                type = point.type || this.o.infowindow_type;
            if (point.html && this.type_to_open[type]) {
                this.o.beforeOpenInfowindow(index, point, marker);
                this.type_to_open[type].call(this, point);
                this.infowindow.open(this.oMap, marker);
                this.o.afterOpenInfowindow(index, point, marker)
            }
        };
        Maplace.prototype.get_html_controls = function() {
            if (this.controls[this.o.controls_type] && this.controls[this.o.controls_type].getHtml) {
                this.current_control = this.controls[this.o.controls_type];
                return this.current_control.getHtml.apply(this)
            }
            return ""
        };
        Maplace.prototype.generate_controls = function() {
            if (!this.o.controls_on_map) {
                this.controls_wrapper.empty();
                this.controls_wrapper.append(this.get_html_controls());
                return
            }
            var cntr = $('<div class="on_gmap ' + this.o.controls_type + ' gmap_controls"></div>').css(this.o.controls_applycss ? {
                    margin: "5px"
                } : {}),
                inner = $(this.get_html_controls()).css(this.o.controls_applycss ? {
                    background: "#fff",
                    padding: "5px",
                    border: "1px solid rgb(113,123,135)",
                    boxShadow: "rgba(0, 0, 0, 0.4) 0px 2px 4px",
                    maxHeight: this.map_div.find(".canvas_map").outerHeight() - 80,
                    minWidth: 100,
                    overflowY: "auto",
                    overflowX: "hidden"
                } : {});
            cntr.append(inner);
            this.oMap.controls[this.o.controls_position].push(cntr.get(0))
        };
        Maplace.prototype.init_map = function() {
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
                            this.markers[i].setMap(null)
                        } catch (err) {
                            self.errors.push(err)
                        }
                    }
                }
                this.markers.length = 0;
                this.markers = []
            }
            if (this.o.controls_on_map && this.oMap.controls) {
                this.oMap.controls[this.o.controls_position].forEach(function(element, index) {
                    try {
                        self.oMap.controls[this.o.controls_position].removeAt(index)
                    } catch (err) {
                        self.errors.push(err)
                    }
                })
            }
            this.oBounds = new google.maps.LatLngBounds();
            this.debug("02")
        };
        Maplace.prototype.perform_load = function() {
            if (this.ln === 1) {
                this.oMap.setCenter(this.markers[0].getPosition());
                this.ViewOnMap(1)
            } else {
                if (this.ln === 0) {
                    if (this.o.map_options.set_center) {
                        this.oMap.setCenter(new google.maps.LatLng(this.o.map_options.set_center[0], this.o.map_options.set_center[1]))
                    } else {
                        this.oMap.fitBounds(this.oBounds)
                    }
                    this.oMap.setZoom(this.o.map_options.zoom)
                } else {
                    this.oMap.fitBounds(this.oBounds);
                    if (typeof(this.o.start - 0) === "number" && this.o.start > 0 && this.o.start <= this.ln) {
                        this.ViewOnMap(this.o.start)
                    } else {
                        this.ViewOnMap(this.view_all_key)
                    }
                }
            }
        };
        Maplace.prototype.debug = function(msg) {
            if (this.dev && this.errors.length) {
                console.log(msg + ": ", this.errors)
            }
        };
        Maplace.prototype.AddControl = function(name, func) {
            if (!name || !func) {
                return false
            }
            this.controls[name] = func;
            return true
        };
        Maplace.prototype.CloseInfoWindow = function() {
            if (this.infowindow && (this.current_index || this.current_index === 0)) {
                this.o.beforeCloseInfowindow(this.current_index, this.o.locations[this.current_index]);
                this.infowindow.close();
                this.infowindow = null;
                this.o.afterCloseInfowindow(this.current_index, this.o.locations[this.current_index])
            }
        };
        Maplace.prototype.ShowOnMenu = function(index) {
            if (index === this.view_all_key && this.o.view_all && this.ln > 1) {
                return true
            }
            index = parseInt(index, 10);
            if (typeof(index - 0) === "number" && index >= 0 && index < this.ln) {
                var visible = this.o.locations[index].visible === false ? false : true,
                    on_menu = this.o.locations[index].on_menu === false ? false : true;
                if (visible && on_menu) {
                    return true
                }
            }
            return false
        };
        Maplace.prototype.ViewOnMap = function(index) {
            if (index === this.view_all_key) {
                this.o.beforeViewAll();
                this.current_index = index;
                if (this.o.locations.length > 0 && this.o.generate_controls && this.current_control && this.current_control.activateCurrent) {
                    this.current_control.activateCurrent.apply(this, [index])
                }
                this.oMap.fitBounds(this.oBounds);
                this.CloseInfoWindow();
                this.o.afterViewAll()
            } else {
                index = parseInt(index, 10);
                if (typeof(index - 0) === "number" && index > 0 && index <= this.ln) {
                    try {
                        google.maps.event.trigger(this.markers[index - 1], "click")
                    } catch (err) {
                        this.errors.push(err.toString())
                    }
                }
            }
            this.debug("03")
        };
        Maplace.prototype.SetLocations = function(locs, reload) {
            this.o.locations = locs;
            reload && this.Load()
        };
        Maplace.prototype.AddLocations = function(locs, reload) {
            var self = this;
            if ($.isArray(locs)) {
                $.each(locs, function(index, value) {
                    self.o.locations.push(value)
                })
            }
            if ($.isPlainObject(locs)) {
                this.o.locations.push(locs)
            }
            reload && this.Load()
        };
        Maplace.prototype.AddLocation = function(location, index, reload) {
            var self = this;
            if ($.isPlainObject(location)) {
                this.o.locations.splice(index, 0, location)
            }
            reload && this.Load()
        };
        Maplace.prototype.RemoveLocations = function(locs, reload) {
            var self = this,
                k = 0;
            if ($.isArray(locs)) {
                $.each(locs, function(index, value) {
                    if ((value - k) < self.ln) {
                        self.o.locations.splice(value - k, 1)
                    }
                    k++
                })
            } else {
                if (locs < this.ln) {
                    this.o.locations.splice(locs, 1)
                }
            }
            reload && this.Load()
        };
        Maplace.prototype.Loaded = function() {
            return this.loaded
        };
        Maplace.prototype._init = function() {
            this.ln = this.o.locations.length;
            for (var i = 0; i < this.ln; i++) {
                $.extend(this.o.locations[i], this.o.commons);
                if (this.o.locations[i].html) {
                    this.o.locations[i].html = this.o.locations[i].html.replace("%index", i + 1);
                    this.o.locations[i].html = this.o.locations[i].html.replace("%title", (this.o.locations[i].title || ""))
                }
            }
            this.map_div = $(this.o.map_div);
            this.controls_wrapper = $(this.o.controls_div)
        };
        Maplace.prototype.Load = function(args) {
            $.extend(true, this.o, args);
            args && args.locations && (this.o.locations = args.locations);
            this._init();
            this.o.visualRefresh === false ? (google.maps.visualRefresh = false) : (google.maps.visualRefresh = true);
            this.init_map();
            this.create_objMap();
            this.add_markers_to_objMap();
            if ((this.ln > 1 && this.o.generate_controls) || this.o.force_generate_controls) {
                this.o.generate_controls = true;
                this.generate_controls()
            } else {
                this.o.generate_controls = false
            }
            var self = this;
            if (!this.loaded) {
                google.maps.event.addListenerOnce(this.oMap, "idle", function() {
                    self.perform_load()
                });
                google.maps.event.addListener(this.oMap, "resize", function() {
                    self.canvas_map.css({
                        width: self.map_div.width(),
                        height: self.map_div.height()
                    })
                });
                var i;
                for (i in this.o.listeners) {
                    var map = this.oMap,
                        myListener = this.o.listeners[i];
                    if (this.o.listeners.hasOwnProperty(i)) {
                        google.maps.event.addListener(this.oMap, i, function(event) {
                            myListener(map, event)
                        })
                    }
                }
            } else {
                this.perform_load()
            }
            this.loaded = true
        };
        return Maplace
    })();
    if (typeof define == "function" && define.amd) {
        define(function() {
            return Maplace
        })
    } else {
        window.Maplace = Maplace
    }
})(jQuery, this, google);



