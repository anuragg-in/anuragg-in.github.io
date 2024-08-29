import matplotlib.pyplot as plt

# Year
x = list(range(2003, 2021))  # Creates a list from 2003 to 2020 (inclusive)
# Social engagement with friends
y = [60, 60, 56, 52, 52, 50, 51, 56, 55, 55, 55, 50, 49, 47, 41, 41, 34, 20]

# Create the plot
plt.figure(figsize=(6, 5))

plt.plot(x, y, marker='o', markersize=8, linestyle='-', label='Data', color='b')

# Adding labels and title
plt.xlabel('Year', fontsize=14, labelpad=10)
plt.ylabel('Average Engagement in Minutes', fontsize=14, labelpad=10)
plt.title('Social Engagement with Friends', fontsize=14, fontweight='bold')

# Set x and y limits
plt.xlim(2002, 2021)  # Set the x-axis limits
plt.ylim(18, 62)       # Set the y-axis limits

# Ensure x markers are less crowded
plt.xticks(range(2003, 2021, 4))  # Set x-ticks every 2 years

plt.savefig('social_engagement_plot.png', dpi=300, bbox_inches='tight', pad_inches=0.01)  # Save the plot as a PNG file

# Display the plot
plt.show()
