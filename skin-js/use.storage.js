/**
 * Module for working with client's local and session storage
 * @type {{setData, getData, removeData, emptyData}}
 */
var UseStorage = ( function () {
    'use strict';

    /**
     * check if Storage is available
     */
    if (typeof Storage === 'undefined') {

        return false;
    }

    /**
     * Defines the type of storage that is used
     *
     * @param type
     * @returns {Storage}
     * @private
     */
    var _setStorage = function (type) {

        return type === 'local' ? localStorage : sessionStorage;
    };

    return {

        /**
         * Functions for session storage data handling
         *
         * setData to write (JSON String)
         * getData to read (returns JS Object)
         * updateData to change single value of property in object
         * removeData to clear key data
         * clearData to clear all data
         *
         * @param type  = type of storage localStorage or sessionStorage
         * @param key   = key in storage
         * @param value = vlaue in storage
         */

        setData: function (type, key, value) {

            if(type && key && value !== undefined) {

                _setStorage(type).setItem(key, JSON.stringify(value));
            }
        },

        getData: function (type, key) {

            if (_setStorage(type).getItem(key) !== null) {

                return JSON.parse(_setStorage(type).getItem(key));

            } else {

                return false;
            }

        },

        updateData: function (type, key, property, value) {

            var obj = this.getData(type, key);

            obj[property] = value;

            this.setData(type, key, obj);
        },

        removeData: function (type, key) {

            if (_setStorage(type).hasOwnProperty(key)) {

                _setStorage(type).removeItem(key);
            }
        },

        clearData: function (type) {

            _setStorage(type).clear();
        }
    };

})();