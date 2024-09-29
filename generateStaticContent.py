import os
import re
from bs4 import BeautifulSoup
blog_base_folder = 'blog_base'  # Path to your blog_base folder
output_folder = 'blog'           # Path to your output folder
linkHeader = "https://www.anuragg.in/"
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

def generate_html(input_filename, output_filename, indent_space=4):
    # Read the body content from the input file
    with open(input_filename, 'r') as file:
        body_content = file.read()

    # Modify links in the body content
    modified_body_content = modify_links(body_content)

    # Indent the modified body content
    indented_body = '\n'.join((' ' * indent_space) + line for line in modified_body_content.splitlines())

    # Define the full HTML structure
    full_html = f"""<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='UTF-8'>
    <meta name='geo.region' content='IN-DL'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='blog.css'>
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <title>Anurag Gupta|Cornell University|IIT Bombay</title>

    <meta name="keywords" content="Anurag Gupta, Master of Science, MS, Master of Technology, M.Tech, Bachelor of Technology, B.Tech, Electrical Engineering, EE, Systems and Control Engineering, SC, SysCon, Electrical and Computer Engineering, Indian Institute of Technology Bombay, Cornell University, Travel, Eco-Tourism, Minimalist"/>
    <meta name="description" content="Anurag Gupta holds an M.S. in Electrical and Computer Engineering from Cornell, an M.Tech in Systems and Control, and a B.Tech from IIT Bombay. Eco-tourism advocate."/>
    <meta name="author" content="Anurag Gupta">

    <meta property="og:title" content="Anurag Gupta | Cornell University | IIT Bombay">
    <meta property="og:type" content="Personal website">
    <meta property="og:url" content="http://www.anuragg.in">
    <meta property="og:description" content="Anurag Gupta is an M.S. graduate in Electrical and Computer Engineering from Cornell University. He also holds an M.Tech degree in Systems and Control Engineering and a B.Tech degree in Electrical Engineering from the Indian Institute of Technology, Bombay. He is a passionate traveller and advocate of eco-tourism and sustainable living.">
    <meta property="og:image" content="images/anurag.png">
    <meta property="og:site_name" content="Anurag Gupta">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="images/anurag.png">
    <meta name="twitter:title" content="Anurag Gupta | Cornell University | Indian Institute of Technology Bombay">
    <meta name="twitter:description" content="Anurag Gupta is an M.S. graduate in Electrical and Computer Engineering from Cornell University. He also holds an M.Tech degree in Systems and Control Engineering and a B.Tech degree in Electrical Engineering from the Indian Institute of Technology, Bombay. He is a passionate traveller and advocate of eco-tourism and sustainable living.">
</head>
<body>
<div class="wrapper">
  <div class="docs-nav-container">
    <ul class="docs-nav">
      <li>
        <a href='https://www.anuragg.in'><strong>Home</strong></a>
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

    # Write the full HTML to the output file
    with open(output_filename, 'w') as file:
        file.write(full_html)

def process_blog_files(blog_base_folder, output_folder):
    # Ensure output folder exists
    os.makedirs(output_folder, exist_ok=True)

    # Get a list of all text files in the blog_base folder
    for filename in os.listdir(blog_base_folder):
        if filename.endswith('.html'):  # Check for .txt files
            input_file = os.path.join(blog_base_folder, filename)
            output_file = os.path.join(output_folder, f"{os.path.splitext(filename)[0]}.html")
            generate_html(input_file, output_file)
            print(f"Generated: {output_file}")

# Example usage
process_blog_files(blog_base_folder, output_folder)
