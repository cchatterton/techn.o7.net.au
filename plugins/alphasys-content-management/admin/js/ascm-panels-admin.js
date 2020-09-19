jQuery(document).ready(function($){

    // ASCM Panels General Settings ==================================================

    if ($('#ascm-mod-settings-fields-cont-panels').length) {

        // hide/show available page panel container
        $('#ascm_panels_availablepages').on('change', function(){
            HideShowPagesPanelContainer();
        });
        HideShowPagesPanelContainer();
        function HideShowPagesPanelContainer(){
            var page_id = $('#ascm_panels_availablepages').val();
            page_id = 'ascm_panels_page_'+page_id+'_cont';
            $('.ascm_panels_pagepanel_cont').each(function( index ) {
                if (page_id == $( this ).attr('id')) {
                    $(this).css('display', 'block');
                }else{
                    $(this).css('display', 'none');
                }
            });
        }

        var ascm_panels_availablepanels_items_cont = document.getElementById('ascm_panels_availablepanels_items_cont');
        new Sortable(ascm_panels_availablepanels_items_cont, {
            group: {
                name: 'ascm_panels_panelstorage',
                pull: 'clone',
                put: false // Do not allow items to be put into this list
            },
            animation: 150,
            sort: false, // To disable sorting: set sort to false
        });

        var ascm_panels_dynamic_vars = {};
        var ascm_panels_availablepages_arr = ascm_modsettings_panels_param.allavailablepages_arr;
        if (ascm_modsettings_panels_param.genesis_detected == false){

            $.each( ascm_panels_availablepages_arr, function( index, value){
                ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_afterheader'] = document.getElementById('ascm_panels_page_'+value+'_afterheader');
                ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_beforecontent'] = document.getElementById('ascm_panels_page_'+value+'_beforecontent');
                ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_aftercontent'] = document.getElementById('ascm_panels_page_'+value+'_aftercontent');
                ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_beforefooter'] = document.getElementById('ascm_panels_page_'+value+'_beforefooter');

                new Sortable(ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_afterheader'] , {
                    group: 'ascm_panels_panelstorage',
                    animation: 150,
                    dataIdAttr: 'data-id',
                    filter: ".js-remove, .js-edit",
                    onFilter: function (evt) {
                        var item = evt.item,
                            ctrl = evt.target;
                        //console.log(item.dataset.id);
                        if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                            item.parentNode.removeChild(item); // remove sortable item

                            var localStorage_items = localStorage.getItem('ascm_panels_panelstorage');

                        } else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link

                        }
                    },
                    scroll: true,
                    scrollSensitivity: 100,
                    scrollSpeed: 1,
                    bubbleScroll: true,
                    emptyInsertThreshold: 20,
                    store: {
                        get: function (sortable) {
                            var order = localStorage.getItem(sortable.options.group);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                            //console.log(order);
                        }
                    },
                });

                new Sortable(ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_beforecontent'] , {
                    group: 'ascm_panels_panelstorage',
                    animation: 150,
                    dataIdAttr: 'data-id',
                    filter: ".js-remove, .js-edit",
                    onFilter: function (evt) {
                        var item = evt.item,
                            ctrl = evt.target;
                        //console.log(item.dataset.id);
                        if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                            item.parentNode.removeChild(item); // remove sortable item

                            var localStorage_items = localStorage.getItem('ascm_panels_panelstorage');

                        } else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link

                        }
                    },
                    scroll: true,
                    scrollSensitivity: 100,
                    scrollSpeed: 1,
                    bubbleScroll: true,
                    emptyInsertThreshold: 20,
                    store: {
                        get: function (sortable) {
                            var order = localStorage.getItem(sortable.options.group);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                            //console.log(order);
                        }
                    },
                });

                new Sortable(ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_aftercontent'] , {
                    group: 'ascm_panels_panelstorage',
                    animation: 150,
                    dataIdAttr: 'data-id',
                    filter: ".js-remove, .js-edit",
                    onFilter: function (evt) {
                        var item = evt.item,
                            ctrl = evt.target;
                        //console.log(item.dataset.id);
                        if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                            item.parentNode.removeChild(item); // remove sortable item

                            var localStorage_items = localStorage.getItem('ascm_panels_panelstorage');

                        } else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link

                        }
                    },
                    scroll: true,
                    scrollSensitivity: 100,
                    scrollSpeed: 1,
                    bubbleScroll: true,
                    emptyInsertThreshold: 20,
                    store: {
                        get: function (sortable) {
                            var order = localStorage.getItem(sortable.options.group);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                            //console.log(order);
                        }
                    },
                });

                new Sortable(ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_beforefooter'] , {
                    group: 'ascm_panels_panelstorage',
                    animation: 150,
                    dataIdAttr: 'data-id',
                    filter: ".js-remove, .js-edit",
                    onFilter: function (evt) {
                        var item = evt.item,
                            ctrl = evt.target;
                        //console.log(item.dataset.id);
                        if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                            item.parentNode.removeChild(item); // remove sortable item

                            var localStorage_items = localStorage.getItem('ascm_panels_panelstorage');

                        } else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link

                        }
                    },
                    scroll: true,
                    scrollSensitivity: 100,
                    scrollSpeed: 1,
                    bubbleScroll: true,
                    emptyInsertThreshold: 20,
                    store: {
                        get: function (sortable) {
                            var order = localStorage.getItem(sortable.options.group);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                            //console.log(order);
                        }
                    },
                });

            });
        }else {

            $.each( ascm_panels_availablepages_arr, function( index, value){
                ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisbeforeheader'] = document.getElementById('ascm_panels_page_'+value+'_genesisbeforeheader');
                ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisafterheader'] = document.getElementById('ascm_panels_page_'+value+'_genesisafterheader');

                ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisbeforeentry'] = document.getElementById('ascm_panels_page_'+value+'_genesisbeforeentry');
                ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisafterentry'] = document.getElementById('ascm_panels_page_'+value+'_genesisafterentry');

                ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisbeforefooter'] = document.getElementById('ascm_panels_page_'+value+'_genesisbeforefooter');
                ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisafterfooter'] = document.getElementById('ascm_panels_page_'+value+'_genesisafterfooter');

                // Genesis Header -----------------------------------------------------------------------
                new Sortable(ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisbeforeheader'] , {
                    group: 'ascm_panels_panelstorage',
                    animation: 150,
                    dataIdAttr: 'data-id',
                    filter: ".js-remove, .js-edit",
                    onFilter: function (evt) {
                        var item = evt.item,
                            ctrl = evt.target;
                        //console.log(item.dataset.id);
                        if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                            item.parentNode.removeChild(item); // remove sortable item

                            var localStorage_items = localStorage.getItem('ascm_panels_panelstorage');

                        } else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link

                        }
                    },
                    scroll: true,
                    scrollSensitivity: 100,
                    scrollSpeed: 1,
                    bubbleScroll: true,
                    emptyInsertThreshold: 20,
                    store: {
                        get: function (sortable) {
                            var order = localStorage.getItem(sortable.options.group);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                            //console.log(order);
                        }
                    },
                });

                new Sortable(ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisafterheader'] , {
                    group: 'ascm_panels_panelstorage',
                    animation: 150,
                    dataIdAttr: 'data-id',
                    filter: ".js-remove, .js-edit",
                    onFilter: function (evt) {
                        var item = evt.item,
                            ctrl = evt.target;
                        //console.log(item.dataset.id);
                        if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                            item.parentNode.removeChild(item); // remove sortable item

                            var localStorage_items = localStorage.getItem('ascm_panels_panelstorage');

                        } else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link

                        }
                    },
                    scroll: true,
                    scrollSensitivity: 100,
                    scrollSpeed: 1,
                    bubbleScroll: true,
                    emptyInsertThreshold: 20,
                    store: {
                        get: function (sortable) {
                            var order = localStorage.getItem(sortable.options.group);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                            //console.log(order);
                        }
                    },
                });
                // Genesis Header -----------------------------------------------------------------------

                // Genesis Content -----------------------------------------------------------------------
                new Sortable(ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisbeforeentry'] , {
                    group: 'ascm_panels_panelstorage',
                    animation: 150,
                    dataIdAttr: 'data-id',
                    filter: ".js-remove, .js-edit",
                    onFilter: function (evt) {
                        var item = evt.item,
                            ctrl = evt.target;
                        //console.log(item.dataset.id);
                        if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                            item.parentNode.removeChild(item); // remove sortable item

                            var localStorage_items = localStorage.getItem('ascm_panels_panelstorage');

                        } else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link

                        }
                    },
                    scroll: true,
                    scrollSensitivity: 100,
                    scrollSpeed: 1,
                    bubbleScroll: true,
                    emptyInsertThreshold: 20,
                    store: {
                        get: function (sortable) {
                            var order = localStorage.getItem(sortable.options.group);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                            //console.log(order);
                        }
                    },
                });

                new Sortable(ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisafterentry'] , {
                    group: 'ascm_panels_panelstorage',
                    animation: 150,
                    dataIdAttr: 'data-id',
                    filter: ".js-remove, .js-edit",
                    onFilter: function (evt) {
                        var item = evt.item,
                            ctrl = evt.target;
                        //console.log(item.dataset.id);
                        if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                            item.parentNode.removeChild(item); // remove sortable item

                            var localStorage_items = localStorage.getItem('ascm_panels_panelstorage');

                        } else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link

                        }
                    },
                    scroll: true,
                    scrollSensitivity: 100,
                    scrollSpeed: 1,
                    bubbleScroll: true,
                    emptyInsertThreshold: 20,
                    store: {
                        get: function (sortable) {
                            var order = localStorage.getItem(sortable.options.group);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                            //console.log(order);
                        }
                    },
                });
                // Genesis Content -----------------------------------------------------------------------

                // Genesis Footer -----------------------------------------------------------------------
                new Sortable(ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisbeforefooter'] , {
                    group: 'ascm_panels_panelstorage',
                    animation: 150,
                    dataIdAttr: 'data-id',
                    filter: ".js-remove, .js-edit",
                    onFilter: function (evt) {
                        var item = evt.item,
                            ctrl = evt.target;
                        //console.log(item.dataset.id);
                        if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                            item.parentNode.removeChild(item); // remove sortable item

                            var localStorage_items = localStorage.getItem('ascm_panels_panelstorage');

                        } else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link

                        }
                    },
                    scroll: true,
                    scrollSensitivity: 100,
                    scrollSpeed: 1,
                    bubbleScroll: true,
                    emptyInsertThreshold: 20,
                    store: {
                        get: function (sortable) {
                            var order = localStorage.getItem(sortable.options.group);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                            //console.log(order);
                        }
                    },
                });

                new Sortable(ascm_panels_dynamic_vars['ascm_panels_page_'+value+'_genesisafterfooter'] , {
                    group: 'ascm_panels_panelstorage',
                    animation: 150,
                    dataIdAttr: 'data-id',
                    filter: ".js-remove, .js-edit",
                    onFilter: function (evt) {
                        var item = evt.item,
                            ctrl = evt.target;
                        //console.log(item.dataset.id);
                        if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                            item.parentNode.removeChild(item); // remove sortable item

                            var localStorage_items = localStorage.getItem('ascm_panels_panelstorage');

                        } else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link

                        }
                    },
                    scroll: true,
                    scrollSensitivity: 100,
                    scrollSpeed: 1,
                    bubbleScroll: true,
                    emptyInsertThreshold: 20,
                    store: {
                        get: function (sortable) {
                            var order = localStorage.getItem(sortable.options.group);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                            //console.log(order);
                        }
                    },
                });
                // Genesis Footer -----------------------------------------------------------------------

            });
        }


        // Toggle View Available Panels ----------------------------------------------------------------------
        $('#ascm-panels-availablepanels-viewpanels-btn').on('click', function(){
            AvailablePanelsToggleView();
        });
        $('#ascm-panels-availablepanels-closepanels-btn').on('click', function(){
            $('#ascm-panels-availablepanels-main-cont').addClass("fadeOutLeft");
            setTimeout(function(){
                AvailablePanelsToggleView();
                $('#ascm-panels-availablepanels-main-cont').removeClass("fadeOutLeft");
            }, 500);

        });
        function AvailablePanelsToggleView(){
            if ($('#ascm-panels-availablepanels-main-cont').hasClass( "ascm_panels_hide" )){
                $('#ascm-panels-availablepanels-main-cont').removeClass("ascm_panels_hide");
            }else{
                $('#ascm-panels-availablepanels-main-cont').addClass("ascm_panels_hide");
            }
        }

        // Save Panels General Settings -----------------------------------------------------------------------
        $('#ascm-mod-settings-save-btn-panels').on('click', function(){
            $('#ascm-mod-settings-loading-cont-panels').removeClass('ascm-hidden');
            $('#ascm-mod-settings-fields-cont-panels').addClass('ascm-disable');
            $('#ascm-mod-settings-save-btn-panels').addClass('ascm-disable');
            $('#ascm-mod-settings-cancel-btn-panels').addClass('ascm-disable');
            SavePanelsSettings();
        });

        function SavePanelsSettings(){
            var page_id = $('#ascm_panels_availablepages').val();

            // Standard Element
            var afterheader_panels = [];
            $('#ascm_panels_page_'+page_id+'_afterheader').find('.ascm-panels-panel-item').each(function(){
                afterheader_panels.push($(this).attr('data-id'));
            });
            console.log(afterheader_panels);

            var beforecontent_panels = [];
            $('#ascm_panels_page_'+page_id+'_beforecontent').find('.ascm-panels-panel-item').each(function(){
                beforecontent_panels.push($(this).attr('data-id'));
            });
            console.log(beforecontent_panels);

            var aftercontent_panels = [];
            $('#ascm_panels_page_'+page_id+'_aftercontent').find('.ascm-panels-panel-item').each(function(){
                aftercontent_panels.push($(this).attr('data-id'));
            });
            console.log(aftercontent_panels);

            var beforefooter_panels = [];
            $('#ascm_panels_page_'+page_id+'_beforefooter').find('.ascm-panels-panel-item').each(function(){
                beforefooter_panels.push($(this).attr('data-id'));
            });
            console.log(beforefooter_panels);


            // Genesis Element
            // Genesis Header --------------------------------------------------------------------------
            var genesisbeforeheader_panels = [];
            $('#ascm_panels_page_'+page_id+'_genesisbeforeheader').find('.ascm-panels-panel-item').each(function(){
                genesisbeforeheader_panels.push($(this).attr('data-id'));
            });
            console.log(genesisbeforeheader_panels);

            var genesisafterheader_panels = [];
            $('#ascm_panels_page_'+page_id+'_genesisafterheader').find('.ascm-panels-panel-item').each(function(){
                genesisafterheader_panels.push($(this).attr('data-id'));
            });
            console.log(genesisafterheader_panels);
            // Genesis Header --------------------------------------------------------------------------

            // Genesis Content --------------------------------------------------------------------------
            var genesisbeforeentry_panels = [];
            $('#ascm_panels_page_'+page_id+'_genesisbeforeentry').find('.ascm-panels-panel-item').each(function(){
                genesisbeforeentry_panels.push($(this).attr('data-id'));
            });
            console.log(genesisbeforeentry_panels);

            var genesisafterentry_panels = [];
            $('#ascm_panels_page_'+page_id+'_genesisafterentry').find('.ascm-panels-panel-item').each(function(){
                genesisafterentry_panels.push($(this).attr('data-id'));
            });
            console.log(genesisafterentry_panels);
            // Genesis Content --------------------------------------------------------------------------

            // Genesis Footer --------------------------------------------------------------------------
            var genesisbeforefooter_panels = [];
            $('#ascm_panels_page_'+page_id+'_genesisbeforefooter').find('.ascm-panels-panel-item').each(function(){
                genesisbeforefooter_panels.push($(this).attr('data-id'));
            });
            console.log(genesisbeforefooter_panels);

            var genesisafterfooter_panels = [];
            $('#ascm_panels_page_'+page_id+'_genesisafterfooter').find('.ascm-panels-panel-item').each(function(){
                genesisafterfooter_panels.push($(this).attr('data-id'));
            });
            console.log(genesisafterfooter_panels);
            // Genesis Footer --------------------------------------------------------------------------

            $.ajax({
                type: 'POST',
                url:  ascm_modsettings_panels_param.url,
                data: {
                    'action':'save_modsettings_panels', 
                    nonce: ascm_modsettings_panels_param.nonce,
                    page_id: page_id,
                    afterheader_panels: afterheader_panels,
                    beforecontent_panels: beforecontent_panels,
                    aftercontent_panels: aftercontent_panels,
                    beforefooter_panels: beforefooter_panels,

                    genesisbeforeheader_panels: genesisbeforeheader_panels,
                    genesisafterheader_panels: genesisafterheader_panels,
                    genesisbeforeentry_panels: genesisbeforeentry_panels,
                    genesisafterentry_panels: genesisafterentry_panels,
                    genesisbeforefooter_panels: genesisbeforefooter_panels,
                    genesisafterfooter_panels: genesisafterfooter_panels,
                },
                success: function(resp) {
                    console.log(resp);
                    setTimeout(function(){
                        $('#ascm-mod-settings-loading-cont-panels').addClass('ascm-hidden');

                        $('#ascm-mod-settings-fields-cont-panels').removeClass('ascm-disable');
                        $('#ascm-mod-settings-save-btn-panels').removeClass('ascm-disable');
                        $('#ascm-mod-settings-cancel-btn-panels').removeClass('ascm-disable');
                    }, 500);
                },
                error: function(resp) {
                    reject( resp );
                    setTimeout(function(){
                        $('#ascm-mod-settings-loading-cont-panels').addClass('ascm-hidden');

                        $('#ascm-mod-settings-fields-cont-panels').removeClass('ascm-disable');
                        $('#ascm-mod-settings-save-btn-panels').removeClass('ascm-disable');
                        $('#ascm-mod-settings-cancel-btn-panels').removeClass('ascm-disable');
                    }, 500);
                }
            });

        }
        
    }


});

