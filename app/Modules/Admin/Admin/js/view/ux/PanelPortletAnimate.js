Ext.define("Admin.view.ux.PanelPortletAnimate",
    {
        extend: "Ext.Panel",
        xtype: 'panelPortletAnimate',
        alias: 'widget.panelPortletAnimate',

        layout: 'fit',
        anchor: '100%',
        frame: true,
        border: false,
        margin: "5 5 10 5",
        closable: true,
        collapsible: true,
        animCollapse: true,
        height: 300,

        draggable:
            {
                moveOnDrag: false
            },

        resizeHandles: 's',
        resizable: true,
        cls: 'x-portlet',

        doClose: function()
        {
            if(!this.closing)
            {
                this.closing = true;
                this.el.animate
                (
                    {
                        opacity: 0,
                        callback: function()
                        {
                            var closeAction = this.closeAction;
                            this.closing = false;
                            this.isStartDestroyed = true;
                            this.fireEvent('close', this);
                            this[closeAction]();

                            if(closeAction == 'hide')
                            {
                                this.el.setOpacity(1);
                            }
                        },
                        scope: this
                    }
                );
            }
        }
    }
);
