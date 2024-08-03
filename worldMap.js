const canvas = document.getElementById('worldMap');
const ctx = canvas.getContext('2d');
const tooltip = document.getElementById('tooltip');

// Sample data for country colors
const countryColors = {
    "USA": "#f00",
    "Chile": "#ff0",
    "Peru": "#ff0",
    "Mexico": "#ff0",
    "Belize": "#ff0",
    "Nicaragua": "#ff0",
    "Puerto Rico": "#ff0",
    "Colombia": "#ff0",
    "Panama": "#ff0",
    "Guatemala": "#ff0",
    "Costa Rica": "#ff0",
    "Honduras": "#ff0",
    "El Salvador": "#ff0",
    "The Bahamas": "#ff0",
    "Dominican Republic": "#ff0",
    "Jamaica": "#ff0",
    "Taiwan": "#ff0",
    "Cuba": "#f0f",
    "Argentina": "#f0f",
    "Haiti": "#f0f",
    "Malaysia": "#0f0",
    "Thailand": "#0f0",
    "Vietnam": "#00f",
    "Cambodia": "#00f",
    "Vietnam": "#00f",
    "India": "#0f0",

    // Add more countries and colors here
};

let countries = [];
let transform = d3.zoomIdentity;

// Load and draw the world map
fetch('https://raw.githubusercontent.com/holtzy/D3-graph-gallery/master/DATA/world.geojson')
    .then(response => response.json())
    .then(worldData => {
        // Exclude Antarctica from the data
        const filteredFeatures = worldData.features.filter(feature => feature.properties.name !== "Antarctica");

        // Get the bounding box for the filtered features
        const bounds = d3.geoBounds({type: "FeatureCollection", features: filteredFeatures});
        const [x0, y0] = bounds[0];
        const [x1, y1] = bounds[1];

        // Set the projection to fit the filtered features
        const projection = d3.geoMercator()
            .fitExtent([[0, 0], [canvas.width, canvas.height]], {type: "FeatureCollection", features: filteredFeatures});
        const path = d3.geoPath().projection(projection);

        // Draw each country and store its path
        filteredFeatures.forEach(feature => {
            const countryName = feature.properties.name;
            const color = countryColors[countryName] || "#CCCCCC"; // Default color if not specified

            ctx.fillStyle = color;
            ctx.beginPath();
            const countryPath = new Path2D(path(feature));
            ctx.fill(countryPath);

            // Draw country border with initial thickness
            ctx.lineWidth = 1 / transform.k; // Adjust line width based on zoom level
            ctx.strokeStyle = '#000'; // Border color
            ctx.stroke(countryPath);

            countries.push({
                name: countryName,
                path: countryPath,
                color: color
            });
        });

        // Add zoom functionality
        const zoom = d3.zoom()
            .scaleExtent([1, 8])  // Zoom levels
            .on('zoom', (event) => {
                transform = event.transform;
                drawMap();  // Redraw the map with the current zoom/pan transform
            });

        d3.select(canvas).call(zoom);

        function drawMap() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);  // Clear the canvas

            ctx.save();
            ctx.translate(transform.x, transform.y);
            ctx.scale(transform.k, transform.k);

            // Redraw each country with adjusted line width
            countries.forEach(country => {
                ctx.fillStyle = country.color;
                ctx.beginPath();
                ctx.fill(country.path);

                // Adjust line width based on zoom level
                ctx.lineWidth = 1 / transform.k; // Adjust line width based on zoom level
                ctx.strokeStyle = '#000'; // Border color
                ctx.stroke(country.path);
            });

            ctx.restore();
        }

        drawMap();
    });

// Add event listener for mouse movements
canvas.addEventListener('mousemove', function(event) {
    const x = event.offsetX;
    const y = event.offsetY;
    let found = false;

    // Clear tooltip
    tooltip.style.display = 'none';

    // Check if mouse is over a country
    for (const country of countries) {
        if (ctx.isPointInPath(country.path, (x - transform.x) / transform.k, (y - transform.y) / transform.k)) {
            tooltip.style.display = 'block';
            tooltip.style.left = `${event.pageX + 10}px`;
            tooltip.style.top = `${event.pageY + 10}px`;
            tooltip.textContent = country.name;
            found = true;
            break;
        }
    }

    if (!found) {
        tooltip.style.display = 'none';
    }
});
