import os
import re
blog_base_folder = 'blog_base'  # Path to your blog_base folder
output_folder = 'blog'           # Path to your output folder
linkHeader = "../"
def modify_links(body_content, prefix=linkHeader):
    # Modify src and href links by adding a prefix
    # Find all src and href attributes
    modified_content = re.sub(
        r'(?P<before>src\s*=\s*["\'])(?P<link>[^"\']+)(?P<after>["\'])',
        lambda m: f'{m.group("before")}{prefix}{m.group("link")}{m.group("after")}',
        body_content
    )

    modified_content = re.sub(
        r'(?P<before>href\s*=\s*["\'])(?P<link>[^"\']+)(?P<after>["\'])',
        lambda m: f'{m.group("before")}{prefix}{m.group("link")}{m.group("after")}',
        modified_content
    )

    return modified_content

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
