Ext.define('Admin.view.ux.ColumnWidget', {
    override: 'Ext.grid.column.Widget',
    
    privates: {
        // OVERRIDE : Bug in ExtJS 5.1.0 - EXTJS-16368
        getFreeWidget: function() {
            var me = this,
                result = me.freeWidgetStack ? me.freeWidgetStack.pop() : null;


            if (!result) {
                result = Ext.widget(me.widget);


                result.resolveListenerScope = me.listenerScopeFn;
                result.getWidgetRecord = me.widgetRecordDecorator;
                result.getWidgetColumn = me.widgetColumnDecorator;
                result.dataIndex = me.dataIndex;
                result.measurer = me;
                result.ownerCmp = me;
                
                if (result.isXType('field')) {
                    result.on({
                        render : me.onWidgetRender
                    })
                }
            }
            return result;
        },
        
        // Override : New method to force focus on widget element when run in IE
        onWidgetRender : function(widget) {
            var element = widget.getEl();
            if (element) {
                element.on({
                   mouseup : function(event, htmlElement) {
                       if (htmlElement.focus) {
                            htmlElement.focus();
                       }
                   }
                });
            }
        }
    }
});