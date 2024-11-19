import os
import json
import re
from bs4 import BeautifulSoup
blog_base_folder = 'blog_base'  # Path to your blog_base folder
output_folder = 'blog'           # Path to your output folder
linkHeader = "https://soln.tech/"

def add_alt_to_images(html_content):
    # Create a BeautifulSoup object
    soup = BeautifulSoup(html_content, 'html.parser')

    # Find all <figure> tags
    for figure in soup.find_all('figure'):
        img = figure.find('img')
        figcaption = figure.find('figcaption')

        # Check if both <img> and <figcaption> exist
        if img and figcaption:
            # Set the alt attribute of the <img> to the text of <figcaption>
            img['alt'] = figcaption.text

    # Return the modified HTML
    return soup.prettify()

# Function to read header information from a JSON file
def read_headers_from_json(file_path):
    with open(file_path, 'r', encoding='utf-8') as file:
        headers = json.load(file)
    return headers

# Function to find a specific entry by filename
def find_header_by_filename(headers, filename):
    for header in headers:
        if header['filename'] == filename:
            return header
    return None

# Function to update the HTML string with new meta tags
def update_html_string(html_string, header_info):
    soup = BeautifulSoup(html_string, 'html.parser')

    # Update title
    if soup.title:
        soup.title.string = header_info['title']
    else:
        new_title = soup.new_tag("title")
        new_title.string = header_info['title']
        soup.head.append(new_title)

    # Update description
    description_tag = soup.find('meta', attrs={'name': 'description'})
    if description_tag:
        description_tag['content'] = header_info['description']
    else:
        new_description = soup.new_tag("meta", attrs={"name": "description", "content": header_info['description']})
        soup.head.append(new_description)

    # Update keywords
    keywords_tag = soup.find('meta', attrs={'name': 'keywords'})
    if keywords_tag:
        keywords_tag['content'] = header_info['keywords']
    else:
        new_keywords = soup.new_tag("meta", attrs={"name": "keywords", "content": header_info['keywords']})
        soup.head.append(new_keywords)

    tag = soup.find('meta', attrs={'property': 'og:title'})
    if tag:
        tag['content'] = header_info['title']
    else:
        new_tag = soup.new_tag("meta", attrs={"property": "og:title", "content": header_info['title']})
        soup.head.append(new_tag)

    tag = soup.find('meta', attrs={'property': 'og:description'})
    if tag:
        tag['content'] = header_info['title']
    else:
        new_tag = soup.new_tag("meta", attrs={"property": "og:description", "content": header_info['description']})
        soup.head.append(new_tag)

    tag = soup.find('meta', attrs={'name': 'twitter:title'})
    if tag:
        tag['content'] = header_info['title']
    else:
        new_tag = soup.new_tag("meta", attrs={"property": "og:title", "content": header_info['title']})
        soup.head.append(new_tag)

    tag = soup.find('meta', attrs={'name': 'twitter:description'})
    if tag:
        tag['content'] = header_info['description']
    else:
        new_tag = soup.new_tag("meta", attrs={"property": "og:description", "content": header_info['description']})
        soup.head.append(new_tag)

    return str(soup)

def modify_links(html, base_url=linkHeader):
    """
    Update href and src attributes in the given HTML.

    Parameters:
    - html (str): The HTML content to modify.
    - base_url (str): The base URL to prepend if href/src doesn't start with http.

    Returns:
    - str: The modified HTML content.
    """
    soup = BeautifulSoup(html, 'html.parser')

    # Update all href attributes
    for a in soup.find_all('a', href=True):
        if not a['href'].startswith('http'):
            a['href'] = base_url + a['href'].strip()

    # Update all src attributes
    for img in soup.find_all('img', src=True):
        if not img['src'].startswith('http'):
            img['src'] = base_url + img['src'].strip()

    return str(soup)
    # # Modify src and href links by adding a prefix
    # # Find all src and href attributes
    # modified_content = re.sub(
    #     r'(?P<before>src\s*=\s*["\'])(?P<link>[^"\']+)(?P<after>["\'])',
    #     lambda m: f'{m.group("before")}{prefix}{m.group("link")}{m.group("after")}',
    #     body_content
    # )
    #
    # modified_content = re.sub(
    #     r'(?P<before>href\s*=\s*["\'])(?P<link>[^"\']+)(?P<after>["\'])',
    #     lambda m: f'{m.group("before")}{prefix}{m.group("link")}{m.group("after")}',
    #     modified_content
    # )
    #
    # return modified_content

def generate_html(filename, input_filename, output_filename, indent_space=4):
    # Read the body content from the input file
    with open(input_filename, 'r') as file:
        body_content = file.read()

    # Modify links in the body content
    modified_body_content = modify_links(body_content)

    # Indent the modified body content
    indented_body = '\n'.join((' ' * indent_space) + line for line in modified_body_content.splitlines())

    indented_body = add_alt_to_images(indented_body)

    # Define the full HTML structure
    full_html = f"""<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='UTF-8'/>
    <meta name='geo.region' content='IN-DL'/>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
    <title>Soln.Tech</title>

    <meta name="keywords" content="technology, solutions, education, research, ideas,Generating Website Content with Scripts,Search Engine Optimization,Free Website Hosting on Github with Customized Domain,shape formation using kilobots,Eclipse Attack Detection on a Blockchain Network,Controlling Transaction Rate in Tangle Ledger,Flyback Converter,Shared Economy for Battery Storage,SVM using Log Barrier Method,Stereovision using Multiple Images,Data Acquisition System for Epstein Tester,Image Stitching for Arbitrary Camera Motion,Hysteresis Loop Modeling in Grain Oriented Magnetic Material,Shape Detection using Generalized Hough Transform,Testing of digital circuits using Beaglebone Black,Pipeline RISC Architecture on FPGA,Measurement of Connectivity in Nanowire Network,Classification of Image Features for Remote Sensing"/>
    <meta name="description" content="Anurag Gupta holds an M.S. in Electrical and Computer Engineering from Cornell, an M.Tech in Systems and Control, and a B.Tech from IIT Bombay. Eco-tourism advocate."/>
    <meta name="author" content="Anurag Gupta"/>

    <meta property="og:title" content="Technology & Solutions"/>
    <meta property="og:type" content="Website"/>
    <meta property="og:url" content="http://soln.tech"/>
    <meta property="og:description" content="Anurag Gupta is an M.S. graduate in Electrical and Computer Engineering from Cornell University. He also holds an M.Tech degree in Systems and Control Engineering and a B.Tech degree in Electrical Engineering from the Indian Institute of Technology, Bombay. He is a passionate traveller and advocate of eco-tourism and sustainable living."/>
    <meta property="og:image" content="https://soln.tech/assets/img/logo.png"/>
    <meta property="og:site_name" content="Technology & Solutions"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:image" content="https://soln.tech/assets/img/logo.png"/>
    <meta name="twitter:title" content="Technology & Solutions"/>
    <meta name="twitter:description" content="Anurag Gupta is an M.S. graduate in Electrical and Computer Engineering from Cornell University. He also holds an M.Tech degree in Systems and Control Engineering and a B.Tech degree in Electrical Engineering from the Indian Institute of Technology, Bombay. He is a passionate traveller and advocate of eco-tourism and sustainable living."/>

    <link rel='stylesheet' href='blog.css'/>
    <link rel="icon" href="https://www.anuragg.in/favicon.ico" type="image/x-icon"/>
</head>
<body>
<div class="wrapper">
  <div class="docs-nav-container">
    <ul class="docs-nav">
      <li>
        <a href='https://soln.tech'><strong>Home</strong></a>
      </li>
    </ul>
  </div>
  <div class="docs-content">
            {indented_body}
    <h2>Author</h2>
    <p><a href="https://www.anuragg.in">Anurag Gupta</a> is an M.S. graduate in Electrical and Computer Engineering from Cornell University. He also holds an M.Tech degree in Systems and Control Engineering and a B.Tech degree in Electrical Engineering from the Indian Institute of Technology, Bombay.</p>
</div>
<script src="blog.js"></script>
</body>
</html>

"""
    json_file_path = 'header.json'
    target_filename = filename  # Change this to the filename you are searching for

    # Read header information from JSON
    headers = read_headers_from_json(json_file_path)

    # Find the specific header entry
    header_info = find_header_by_filename(headers, target_filename)

    # Check if the header info was found
    if header_info:
        # Update the HTML string
        updated_html = update_html_string(full_html, header_info)
        # Write the full HTML to the output file
        with open(output_filename, 'w') as file:
            file.write(updated_html)
    else:
        print(f"No header information found for {target_filename}.")

    # Outp

def process_blog_files(blog_base_folder, output_folder):
    # Ensure output folder exists
    os.makedirs(output_folder, exist_ok=True)

    # Get a list of all text files in the blog_base folder
    for filename in os.listdir(blog_base_folder):
        if filename.endswith('.html'):  # Check for .txt files
            input_file = os.path.join(blog_base_folder, filename)
            output_file = os.path.join(output_folder, f"{os.path.splitext(filename)[0]}.html")
            generate_html(filename, input_file, output_file)
            print(f"Generated: {output_file}")

# Example usage
process_blog_files(blog_base_folder, output_folder)
