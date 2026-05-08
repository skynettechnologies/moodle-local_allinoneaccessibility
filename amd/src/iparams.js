// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * All in One Accessibility AMD module.
 *
 * @copyright  2024 Rajesh Bhimani <developer3@skynettechnologies.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define([], function() {
    var useremail = '';
    var username = '';
    var domainname = '';
    var websitename = '';

    /**
     * Register the domain.
     *
     * @param {string} websitename Website URL
     * @returns {Promise<Object>} JSON response from API
     */
    function fetchApiData(websitename) {
        const apiUrlExistcheck = 'https://ada.skynettechnologies.us/api/get-autologin-link-new';

        const data = {
            website: websitename,
        };

        // Use the Fetch API to make the POST request
        return fetch(apiUrlExistcheck, {
            method: 'POST', // Use POST method
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded' // Equivalent to 'http_build_query' in PHP
            },
            body: new URLSearchParams(data).toString() // Convert data object to URL-encoded query string
        })
            .then(response => response.json()) // Parse the response as JSON
            .then(responseArr => {
                // Check if the 'status' key exists and has a value of 0
                if (!responseArr.hasOwnProperty('status') || (responseArr.hasOwnProperty('status') && responseArr.status === 0)) {
                    let norequiredeu = 1;
                    fetch("https://ipapi.co/json/")
                    .then(response => response.json())
                    .then(euresponse => {
                        if (euresponse && euresponse.in_eu) {
                            norequiredeu = 0;
                        }
                    });
                    const packageType = "free-widget";
                    const arrDetails = {
                        name: username,
                        email: useremail,
                        company_name: '',
                        website: websitename,
                        package_type: packageType,
                        start_date: new Date().toISOString(),
                        end_date: '',
                        price: '',
                        discount_price: '0',
                        platform: 'Moodle',
                        api_key: '',
                        is_trial_period: '',
                        is_free_widget: '1',
                        bill_address: '',
                        country: '',
                        state: '',
                        city: '',
                        post_code: '',
                        transaction_id: '',
                        subscr_id: '',
                        payment_source: '',
                        no_required_eu: norequiredeu
                    };
                    const apiUrl = "https://ada.skynettechnologies.us/api/add-user-domain";

                    fetch(apiUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(arrDetails)
                    })
                    .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .finally(() => {
                            // Optional: hide loader if you're using one
                        });
                }
                if (!responseArr.ok) {
                    return false;
                    //throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return responseArr.json();
            });
    }

    const imagesPaths = "https://www.skynettechnologies.com/sites/default/files/";

    const dSettings = {
        widget_position: "bottom_right",
        widget_color_code: "#420083",
        widget_icon_type: "aioa-icon-type-1",
        widget_icon_size: "aioa-medium-icon",
    };

    /**
     * Fetch the widget settings and set element value
     *
     * @param {string} domainname Website URL
     * @returns {Promise<Object>} JSON response from API
     */
    function fetchApiResponse(domainname) {
        const apiUrl = "https://ada.skynettechnologies.us/api/widget-settings";

        return fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json" // Specify the content type
            },
            body: JSON.stringify({ website_url: domainname }) // Pass the domain name in the request body
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json(); // Parse the JSON response
            })
            .then((result) => {
                // Check if result and result.Data are valid
                if (result && result.Data && Object.keys(result.Data).length > 0) {
                    const settings = {
                        widget_position: result.Data.widget_position || dSettings.widget_position,
                        widget_color_code: result.Data.widget_color_code || dSettings.widget_color_code,
                        widget_icon_type: result.Data.widget_icon_type || dSettings.widget_icon_type,
                        widget_icon_size: result.Data.widget_icon_size || dSettings.widget_icon_size,
                        widget_size: result.Data.widget_size || dSettings.widget_size,
                        widget_icon_size_custom: result.Data.widget_icon_size_custom || dSettings.widget_icon_size_custom,
                        is_widget_custom_size: result.Data.is_widget_custom_size || dSettings.is_widget_custom_size,
                        is_widget_custom_position: result.Data.is_widget_custom_position || dSettings.is_widget_custom_position,
                        widget_position_top: result.Data.widget_position_top || 0,
                        widget_position_bottom: result.Data.widget_position_bottom || 0,
                        widget_position_left: result.Data.widget_position_left || 0,
                        widget_position_right: result.Data.widget_position_right || 0,
                    };

                    populateSettings(settings);
                    populatecustom(settings);
                    // You can process the settings here or pass them to another function
                }
                return result.json(); // Parse the JSON response
            });
    }
    /**
     * Fetch the widget settings
     *
     * @returns null
     */
    function fetchSettings() {
        const requestOptions = {
            method: "POST",
            redirect: "follow"
        };

        fetch(`https://ada.skynettechnologies.us/api/widget-settings?website_url=${domainname}`, requestOptions)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Parse JSON response
            })
            .catch(() => {
                hideLoader();
            })
            .finally(() => {
                // Hide loader after fetching data is complete (success or error)
                hideLoader();
            });


    }
    /**
     * Populate form fields with settings
     *
     * @param {string} settings Website URL
     * @returns {void}
     */
    function populateSettings(settings) {

        /**
         * Show elements on event
         *
         * @param {string} selector Website URL
         * @returns {void}
         */
        function showElements(selector) {
            document.querySelectorAll(selector).forEach(el => el.classList.remove('hide'));
        }

        /**
         * Hide elements on event
         *
         * @param {string} selector element
         * @returns {void}
         */
        function hideElements(selector) {
            document.querySelectorAll(selector).forEach(el => el.classList.add('hide'));
        }

        /**
         * Add Class to clossest checkbox functions
         *
         * @param {string} inputId input id
         * @param {string} className class name
         * @returns {void}
         */
        function addClassToClosestCheckbox(inputId, className) {
            const input = document.getElementById(inputId);
            if (!input) {
                return;
            }
            const closest = input.closest('.custom-checkbox');
            if (closest) {
                closest.classList.add(className);
            }
        }

        /**
         * Remove Class to clossest checkbox functions
         *
         * @param {string} inputId input id
         * @param {string} className class name
         * @returns {void}
         */
        function removeClassFromClosestCheckbox(inputId, className) {
            const input = document.getElementById(inputId);
            if (!input) {
                return;
            }
            const closest = input.closest('.custom-checkbox');
            if (closest) {
                closest.classList.remove(className);
            }
        }

        /**
         * Update custom size functions
         *
         * @returns {void}
         */
        function updateCustomSizeUI() {
            const isCustom = settings.is_widget_custom_size === 1;
            const switcher = document.getElementById('custom-size-switcher');
            if (switcher) {
                switcher.checked = isCustom;
            }

            if (isCustom) {
                showElements('.custom-size-controls');
                hideElements('.widget-icon');
                addClassToClosestCheckbox('custom-size-switcher', 'selected');
            } else {
                hideElements('.custom-size-controls');
                showElements('.widget-icon');
                removeClassFromClosestCheckbox('custom-size-switcher', 'selected');
            }
        }

        /**
         * Update custom position functions
         *
         * @returns {void}
         */
        function updateCustomPositionUI() {
            const isCustom = settings.is_widget_custom_position === 1;
            const switcher = document.getElementById('custom-position-switcher');
            if (switcher) {
                switcher.checked = isCustom;
            }

            if (isCustom) {
                showElements('.custom-position-controls');
                hideElements('.widget-position');
                addClassToClosestCheckbox('custom-position-switcher', 'selected');
            } else {
                hideElements('.custom-position-controls');
                showElements('.widget-position');
                removeClassFromClosestCheckbox('custom-position-switcher', 'selected');
            }
        }

        // Event listeners
        const customSizeSwitcher = document.getElementById('custom-size-switcher');
        if (customSizeSwitcher) {
            customSizeSwitcher.addEventListener('click', () => {
                settings.is_widget_custom_size = customSizeSwitcher.checked ? 1 : 0;
                updateCustomSizeUI();
            });
        }

        const customPositionSwitcher = document.getElementById('custom-position-switcher');
        if (customPositionSwitcher) {
            customPositionSwitcher.addEventListener('click', () => {
                settings.is_widget_custom_position = customPositionSwitcher.checked ? 1 : 0;
                updateCustomPositionUI();
            });
        }

        // Initial UI update
        updateCustomSizeUI();
        updateCustomPositionUI();

        // Simulated API update after fetching settings
        setTimeout(() => {
            updateCustomSizeUI();
            updateCustomPositionUI();
        }, 1000);

        // Color field
        const colorField = document.getElementById("colorcode");
        if (colorField) {
            colorField.value = settings.widget_color_code;
        }

        // Icon type radios
        const typeOptions = document.querySelectorAll('input[name="aioa_icon_type"]');
        typeOptions.forEach(option => {
            option.checked = option.value === settings.widget_icon_type;
        });

        // Icon size radios
        const sizeOptions = document.querySelectorAll('input[name="aioa_icon_size"]');
        sizeOptions.forEach(option => {
            option.checked = option.value === settings.widget_icon_size;
        });

        // Icon image
        const iconImg = document.querySelector(".iconimg");
        if (iconImg) {
            iconImg.src = `${imagesPaths}${settings.widget_icon_type}.svg`;
        }

        // Custom icon size input
        const widgetIconSizeCustom = document.getElementById("widget_icon_size_custom");
        if (widgetIconSizeCustom) {
            widgetIconSizeCustom.value = settings.widget_icon_size_custom;
        }

        // Position radios
        const positionRadio = document.querySelector(`input[name="position"][value="${settings.widget_position}"]`);
        if (positionRadio) {
            positionRadio.checked = true;
        }

        // Widget size radios
        const widgetSizeRadio = document.querySelector(`input[name="widget_size"][value="${settings.widget_size}"]`);
        if (widgetSizeRadio) {
            widgetSizeRadio.checked = true;
        }

        // Custom position fields
        const customPositionXField = document.getElementById("custom_position_x_value");
        const xDirectionSelect = document.querySelectorAll(".custom-position-controls select")[0];
        if (customPositionXField && xDirectionSelect) {
            if (settings.widget_position_right > 0) {
                customPositionXField.value = settings.widget_position_right;
                xDirectionSelect.value = "cust-pos-to-the-right";
            } else if (settings.widget_position_left > 0) {
                customPositionXField.value = settings.widget_position_left;
                xDirectionSelect.value = "cust-pos-to-the-left";
            } else {
                customPositionXField.value = 0;
                xDirectionSelect.value = "cust-pos-to-the-right";
            }
        }

        const customPositionYField = document.getElementById("custom_position_y_value");
        const yDirectionSelect = document.querySelectorAll(".custom-position-controls select")[1];
        if (customPositionYField && yDirectionSelect) {
            if (settings.widget_position_bottom > 0) {
                customPositionYField.value = settings.widget_position_bottom;
                yDirectionSelect.value = "cust-pos-to-the-lower";
            } else if (settings.widget_position_top > 0) {
                customPositionYField.value = settings.widget_position_top;
                yDirectionSelect.value = "cust-pos-to-the-upper";
            } else {
                customPositionYField.value = 0;
                yDirectionSelect.value = "cust-pos-to-the-lower";
            }
        }
    }

    /**
     * Show loader function.
     *
     * @returns {void}
     */
    function showLoader() {
        var loader = document.getElementById('loader');
        if (loader) {
            loader.style.display = 'flex'; // Show loader
        }
    }
    /**
     * Hide loader function.
     *
     * @returns {void}
     */
    function hideLoader() {
        var loader = document.getElementById('loader');
        if (loader) {
            loader.style.display = 'none'; // Hide loader
        }
    }
    /**
     * Initilize all element.
     *
     * @returns {void}
     */
    function initEvents() {
        const sizeOptions = document.querySelectorAll('input[name="aioa_icon_size"]');
        const sizeOptionsImg = document.querySelectorAll('input[name="aioa_icon_size"] + label img');
        const typeOptions = document.querySelectorAll('input[name="aioa_icon_type"]');
        const positionOptions = document.querySelectorAll('input[name="position"]');
        const custSizePreview = document.querySelector(".custom-size-preview img");
        const custSizePreviewLabel = document.querySelector(".custom-size-preview .value span");
        // Set default value to custom position inputs
        var positions = {
            top_left: [20, 20],
            middel_left: [20, 50],
            bottom_center: [50, 20],
            top_center: [50, 20],
            middel_right: [20, 50],
            bottom_right: [20, 20],
            top_right: [20, 20],
            bottom_left: [20, 20],
        };
        positionOptions.forEach((option) => {
            const icoPosition = document.querySelector('input[name="position"]:checked').value;
            document.getElementById("custom_position_x_value").value = positions[icoPosition][0];
            document.getElementById("custom_position_y_value").value = positions[icoPosition][1];
            option.addEventListener("click", () => {
                const icoPosition = document.querySelector('input[name="position"]:checked').value;
                document.getElementById("custom_position_x_value").value = positions[icoPosition][0];
                document.getElementById("custom_position_y_value").value = positions[icoPosition][1];
            });
        });
        // Set icon on type select
        typeOptions.forEach((option) => {
            option.addEventListener("click", () => {
                const icoType = 'aioa-icon-type-'+(document.querySelector('input[name="aioa_icon_type"]:checked').value);

                sizeOptionsImg.forEach((option2) => {
                    option2.setAttribute("src", imagesPaths + icoType + ".svg");
                });
                custSizePreview.setAttribute("src", imagesPaths + icoType + ".svg");
            });
        });
        // Set icon on size select
        sizeOptions.forEach((option) => {
            // Set default value to custom size input
            const widgeticonsizecustom = document.getElementById("widget_icon_size_custom");
            document.getElementById("widget_icon_size_custom").value = widgeticonsizecustom;


            option.addEventListener("click", () => {
                var icowidth = document
                    .querySelector('input[name="aioa_icon_size"]:checked + label img')
                    .getAttribute("width");
                var icoheight = document
                    .querySelector('input[name="aioa_icon_size"]:checked + label img')
                    .getAttribute("height");
                custSizePreview.setAttribute("width", icowidth);
                custSizePreview.setAttribute("height", icoheight);
                document.getElementById("widget_icon_size_custom").value = icowidth;
                custSizePreviewLabel.innerHTML = icowidth;
            });
        });
        // Set icons size on input change
        document.getElementById("widget_icon_size_custom").addEventListener("input", function () {
            var icosizevalue = document.getElementById("widget_icon_size_custom").value;
            if (icosizevalue >= 20 && icosizevalue <= 150) {
                custSizePreview.setAttribute("width", icosizevalue);
                custSizePreview.setAttribute("height", icosizevalue);
                custSizePreviewLabel.innerHTML = icosizevalue;
            }
        });
    }

    let iswidgetcustomposition = 0;
    let iswidgetcustomsize = 0;

    /**
     * Populate Custom code
     * @param {Object} settings Configuration object
     * @returns {void}
     */
    function populatecustom(settings) {
        // Initialize variables with defaults if undefined
        let iswidgetcustomposition = settings.is_widget_custom_position !== undefined ? settings.is_widget_custom_position : 0;
        let iswidgetcustomsize = settings.is_widget_custom_size !== undefined ? settings.is_widget_custom_size : 0;

        // Get the DOM elements
        const positionSwitcher = document.getElementById('custom-position-switcher');
        const sizeSwitcher = document.getElementById('custom-size-switcher');

        // Set initial checkbox states
        if (positionSwitcher) {
            positionSwitcher.checked = iswidgetcustomposition === 1;
        }
        if (sizeSwitcher) {
            sizeSwitcher.checked = iswidgetcustomsize === 1;
        }

        // Add event listener for custom position switcher
        if (positionSwitcher) {
            positionSwitcher.addEventListener('click', function() {
                iswidgetcustomposition = this.checked ? 1 : 0;
            });
        }

        // Add event listener for custom size switcher
        if (sizeSwitcher) {
            sizeSwitcher.addEventListener('click', function() {
                iswidgetcustomsize = this.checked ? 1 : 0;
            });
        }
    }

    /**
     * Populate Custom code
     *
     * @returns {void}
     */
    function saveAioaSettings() {
        const server_name = domainname;
        const loader = document.getElementById('loader');
        loader.style.display = 'flex';

        // Get values from inputs
        const colorcode = document.getElementById('colorcode').value;
        const iconposition = document.querySelector('input[name="position"]:checked')?.value;
        const icontype = document.querySelector('input[name="aioa_icon_type"]:checked')?.value;
        const iconsize = document.querySelector('input[name="aioa_icon_size"]:checked')?.value;
        const widgetsize = document.querySelector('input[name="widget_size"]:checked')?.value;
        const widgeticonsizecustom = document.getElementById('widget_icon_size_custom')?.value;

        // Validate custom icon size
        if (iswidgetcustomsize === 1) {
            const customSize = parseInt(widgeticonsizecustom, 10);
            if (isNaN(customSize) || customSize < 20 || customSize > 150) {
                loader.style.display = 'none';
                return;
            }
        }

        // Get custom position values
        const custompositionx = document.getElementById('custom_position_x_value')?.value || 0;
        const custompositiony = document.getElementById('custom_position_y_value')?.value || 0;

        // Get select values for x and y directions
        const positionSelects = document.querySelectorAll('.custom-position-controls select');
        const xpositiondirection = positionSelects[0]?.value;
        const ypositiondirection = positionSelects[1]?.value;

        // Calculate widget positions
        let widgetpositionright = null;
        let widgetpositionleft = null;
        let widgetpositiontop = null;
        let widgetpositionbottom = null;

        if (xpositiondirection === "cust-pos-to-the-right") {
            widgetpositionright = custompositionx;
        } else if (xpositiondirection === "cust-pos-to-the-left") {
            widgetpositionleft = custompositionx;
        }

        if (ypositiondirection === "cust-pos-to-the-lower") {
            widgetpositionbottom = custompositiony;
        } else if (ypositiondirection === "cust-pos-to-the-upper") {
            widgetpositiontop = custompositiony;
        }

        // Prepare params
        const params = new URLSearchParams({
            u: server_name,
            widget_position: iconposition,
            is_widget_custom_position: iswidgetcustomposition,
            is_widget_custom_size: iswidgetcustomsize,
            widget_color_code: colorcode,
            widget_icon_type: icontype,
            widget_icon_size: iconsize,
            widget_size: widgetsize,
            widget_icon_size_custom: widgeticonsizecustom,
            widget_position_right: widgetpositionright,
            widget_position_left: widgetpositionleft,
            widget_position_top: widgetpositiontop,
            widget_position_bottom: widgetpositionbottom,
            platform: 'Moodle'
        }).toString();

        // Send request via XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'https://ada.skynettechnologies.us/api/widget-setting-update-platform', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            loader.style.display = 'none';
            if (xhr.status === 200) {
                // Settings updated successfully
                // location.reload(); // Uncomment if needed
            }
        };

        xhr.onerror = function() {
            loader.style.display = 'none';
        };

        xhr.send(params);
    }

    const submitButton = document.getElementById('submit');
    if (submitButton) {
        submitButton.addEventListener('click', function () {
            saveAioaSettings();
        });
    }

    /**
     * Initialize the accessibility module.
     *
     * @returns {void}
     */
    function init() {
        const confirmBtn = document.getElementById('aio-confirm-and-connect');
        confirmBtn.addEventListener('click', function() {
            fetch(M.cfg.wwwroot +
                '/local/allinoneaccessibility/ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=register&sesskey=' + M.cfg.sesskey
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    window.location.reload();
                }
            });
        });
        const isconfirmed = document.getElementById('isconfirmed').value;
        if (isconfirmed == '1') {
            const dataConfirmationSection = document.getElementById('data_confirmation_section');
            const widgetForm = document.getElementById('widget-form');
            widgetForm.style.display = 'block';
            dataConfirmationSection.style.display = 'none';
            const domain = window.location.hostname;
            if (!domain) {
                return;
            }
            username = domain;
            useremail = 'no-reply@'+domain;
            websitename = btoa(domain);
            domainname = domain;
            showLoader();
            initEvents();
            fetchSettings();

            // Register domain
            fetchApiResponse(domainname).then(function() {
                // Fetch scan details
                return fetchApiData(websitename);
            }).then(function() {
                // Render the UI
                hideLoader();
            }).catch(function() {
                return false;
            });
        }
    }

    return {
        init: init
    };
});