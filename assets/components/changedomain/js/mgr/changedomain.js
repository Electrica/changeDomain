var changeDomain = function (config) {
    config = config || {};
    changeDomain.superclass.constructor.call(this, config);
};
Ext.extend(changeDomain, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('changedomain', changeDomain);

changeDomain = new changeDomain();