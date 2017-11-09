Ext.Loader.setPath('Ext.ux.TreePicker', 'bower_modules/extjs/packages/ux/classic/src/TreePicker.js');

Ext.define('Admin.view.ux.TreePicker',
    {
    extend: 'Ext.ux.TreePicker',
    xtype: 'treepicker',

        createPicker: function()
        {
            var me = this,
                picker = new Ext.tree.Panel
                (
                    {
                    baseCls: Ext.baseCSSPrefix + 'boundlist',
                    shrinkWrapDock: 2,
                    store: me.store,
                    floating: true,
                    displayField: me.displayField,
                    rootVisible: me.rootVisible,
                    columns: me.columns,
                    minHeight: me.minPickerHeight,
                    maxHeight: me.maxPickerHeight,
                    manageHeight: false,
                    shadow: false,
                        listeners:
                        {
                        scope: me,
                        itemclick: me.onItemClick,
                        itemkeydown: me.onPickerKeyDown
                        }
                    }
                ),
            view = picker.getView();

            if(Ext.isIE9 && Ext.isStrict)
            {
                view.on
                (
                    {
                    scope: me,
                    highlightitem: me.repaintPickerView,
                    unhighlightitem: me.repaintPickerView,
                    afteritemexpand: me.repaintPickerView,
                    afteritemcollapse: me.repaintPickerView
                    }
                );
            }

        return picker;
        }
    }
);
