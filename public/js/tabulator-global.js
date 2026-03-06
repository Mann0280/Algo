/**
 * GLOBAL TABULATOR CONFIGURATION
 * Applied across all tables to ensure consistent behavior and UI protection.
 */
const TABULATOR_BASE_CONFIG = {
    layout: "fitColumns",
    responsiveLayout: "collapse",
    movableColumns: true,
    resizableColumns: true,
    columnDefaults: {
        minWidth: 120,
        maxWidth: 320,
        headerSort: true
    },
    placeholder: "<div style='padding:20px;text-align:center;color:#6b7280;font-size:12px;text-transform:uppercase;letter-spacing:0.1em;font-family:Orbitron,monospace;'>No data available</div>",
    pagination: "local", // local for json data we pass in directly, 'remote' for ajax 
    paginationSize: 10,
    movableRows: false,
    virtualDom: true, // Performance safeguard for > 1000 rows
};
