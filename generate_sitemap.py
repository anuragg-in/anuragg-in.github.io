import os
import xml.etree.ElementTree as ET

# Function to create a URL element for the sitemap
def create_url_element(url):
    url_element = ET.Element("url")
    loc = ET.SubElement(url_element, "loc")
    loc.text = url
    return url_element

# Function to indent the XML tree for pretty printing
def indent(elem, level=0):
    i = "\n" + level * "  "
    if len(elem):
        if not elem.text or not elem.text.strip():
            elem.text = i + "  "
        if not elem.tail or not elem.tail.strip():
            elem.tail = i
        for subelem in elem:
            indent(subelem, level + 1)
        if not subelem.tail or not subelem.tail.strip():
            subelem.tail = i
    else:
        if level and (not elem.tail or not elem.tail.strip()):
            elem.tail = i

# Function to generate sitemap without going into subdirectories
def generate_sitemap():
    # Root element for the sitemap with the additional xmlns:xhtml attribute
    urlset = ET.Element("urlset", {
        "xmlns": "http://www.sitemaps.org/schemas/sitemap/0.9",
        "xmlns:xhtml": "http://www.w3.org/1999/xhtml"
    })

    # Base URL
    base_url = "https://www.anuragg.in/"

    # Directories to check (current directory and blog folder)
    directories = [os.getcwd(), os.path.join(os.getcwd(), "blog")]

    for directory in directories:
        # List files in the directory (do not go into subdirectories)
        for filename in os.listdir(directory):
            if filename.endswith('.html'):
                # Generate the relative path and create the full URL
                relative_path = os.path.relpath(os.path.join(directory, filename), os.getcwd()).replace("\\", "/")
                full_url = base_url + relative_path

                # Append the URL element to the sitemap
                url_element = create_url_element(full_url)
                urlset.append(url_element)

    # Indent the XML for proper formatting
    indent(urlset)

    # Write the sitemap to an XML file with proper XML declaration and formatting
    tree = ET.ElementTree(urlset)
    with open("sitemap.xml", "wb") as f:
        tree.write(f, encoding="utf-8", xml_declaration=True)

    print("Sitemap generated successfully as 'sitemap.xml'.")

# Run the function to generate the sitemap
generate_sitemap()
