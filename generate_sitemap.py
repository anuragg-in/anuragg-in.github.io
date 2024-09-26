import os
import xml.etree.ElementTree as ET
from urllib.parse import urljoin
import xml.dom.minidom as minidom

def generate_sitemap(base_url, exclude_files=None):
    if exclude_files is None:
        exclude_files = []

    # Create the root of the XML document
    urlset = ET.Element("urlset", {
        "xmlns": "http://www.sitemaps.org/schemas/sitemap/0.9",
        "xmlns:xhtml": "http://www.w3.org/1999/xhtml"
    })

    # Iterate through all files in the current directory
    for file in os.listdir('.'):
        # Only include .html files and skip excluded files
        if file.endswith(".html") and file not in exclude_files:
            # Create the <url> element
            url_element = ET.SubElement(urlset, "url")

            # Create the <loc> element with the full URL
            loc = ET.SubElement(url_element, "loc")
            loc.text = urljoin(base_url, file)

    # Convert the ElementTree to a string
    rough_string = ET.tostring(urlset, 'utf-8')

    # Use minidom to add proper indentation
    reparsed = minidom.parseString(rough_string)
    pretty_xml = reparsed.toprettyxml(indent="  ", newl='\n')

    # Write the prettified XML to a file
    with open("sitemap.xml", "w", encoding="utf-8") as f:
        f.write(pretty_xml)

    print("Sitemap generated successfully with proper indentation and EOL.")

# Usage example
base_url = "https://www.anuragg.in/"
exclude_files = ["top.html", "bottom.html"]  # Add files to exclude if needed

generate_sitemap(base_url, exclude_files)
