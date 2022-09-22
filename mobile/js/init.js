/* jshint esversion: 6 */

const that = this;

class AddonTabsFilterHandler{

    constructor() {
        this.name = 'AddonTabsFilterHandler';
        this.filterName = 'tabs';
        this.timeoutId = 0;
    }

    isEnabled(){
        return true;
    }

    shouldBeApplied(options, site){
        // Only apply the filter if logged in and we're filtering current site.
        return !!(site && site.getId() == that.CoreSitesProvider.getCurrentSiteId());
    }

    filter(text, filter, options, siteId){
        return text;
    }

    handleHtml(container, filter, options, viewContainerRef, component, componentId, siteId){
        if(container.innerHTML.indexOf("filter-tabs-bootstrap") !== -1){
            // in case of multiple tab groups cancel current timeout, last timeout processes all tab groups
            clearTimeout(this.timeoutId);
            this.timeoutId = setTimeout(() => {
                this.processTabs();
            },500);
        }
    }

    processTabs(){
        let tabGroupsElems = document.querySelectorAll("[id^='filter-tabs-tabgroup-']");
        let tabGroups = [];

        for (let tgeIdx = 0; tgeIdx < tabGroupsElems.length; tgeIdx++) {

            let tabGroup = {
                'tabs' : tabGroupsElems[tgeIdx].querySelectorAll(".nav-tabs>li>a.filter-tabs"),
                'panes': tabGroupsElems[tgeIdx].querySelectorAll(".tab-content>div.filter-tabs"),
                'printable': tabGroupsElems[tgeIdx].querySelectorAll("[id$='-printable']")
            };


            for (let tgIdx = 0; tgIdx < tabGroup.tabs.length; tgIdx++) {
                tabGroup.tabs[tgIdx].removeAttribute("href");
                tabGroup.tabs[tgIdx].classList.remove('filter-tabs');
                tabGroup.panes[tgIdx].classList.remove("filter-tabs");
                tabGroup.printable[tgIdx].remove();
            }
            tabGroups[tgeIdx] = tabGroup;
        }

        for (let gidx = 0; gidx < tabGroups.length; gidx++) {
            for (let tidx = 0; tidx < tabGroups[gidx].tabs.length; tidx++) {
                tabGroups[gidx].tabs[tidx].setAttribute('data-gid', gidx);
                tabGroups[gidx].tabs[tidx].addEventListener("click", function () {
                    let tbGrpIdx = event.target.getAttribute('data-gid');
                    let tabs = tabGroups[tbGrpIdx].tabs;
                    let panes = tabGroups[tbGrpIdx].panes;
                    for (let i1 = 0; i1 < tabs.length; i1++) tabs[i1].classList.remove("active");

                    for (let i2 = 0; i2 < panes.length; i2++) panes[i2].classList.remove("show", "active");

                    let tab = event.target.classList;
                    let pane = document.getElementById((event.target.getAttribute("aria-controls"))).classList;

                    tab.add("active");
                    pane.add("show", "active");
                });
            }
        }
    }
}

this.CoreFilterDelegate.registerHandler(new AddonTabsFilterHandler());

