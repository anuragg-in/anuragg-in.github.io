import os
import re

def replace_tags():
    # Get the current working directory
    folder_path = os.getcwd()

    # Loop through all files in the current folder
    for filename in os.listdir(folder_path):
        if filename.endswith('.html'):  # Process .html
            file_path = os.path.join(folder_path, filename)

            # Read the file content
            with open(file_path, 'r', encoding='utf-8') as file:
                content = file.read()

            # Replace <div class="heading"> with <h2>
            modified_content = re.sub(r'<div\s+class\s*=\s*"heading">', '<h2>', content)
            modified_content = re.sub(r'</div>\s*', '</h2>', modified_content)

            # Replace <div class="image"> with <figure>
            modified_content = re.sub(r'<div\s+class\s*=\s*"image">', '<figure>', modified_content)
            modified_content = re.sub(r'</div>\s*', '</figure>', modified_content)

            # Replace <div class="caption"> with <figcaption>
            modified_content = re.sub(r'<div\s+class\s*=\s*"caption">', '<figcaption>', modified_content)
            modified_content = re.sub(r'</div>\s*', '</figcaption>', modified_content)

            # Replace
            modified_content = re.sub(r'<div\s+class\s*=\s*"text">', '<p>', modified_content)
            modified_content = re.sub(r'</div>\s*', '</p>', modified_content)

            # Write the modified content back to the file
            with open(file_path, 'w', encoding='utf-8') as file:
                file.write(modified_content)

            print(f"Processed: {filename}")

# Run the function to replace tags in the current folder
replace_tags()
