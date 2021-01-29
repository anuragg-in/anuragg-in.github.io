%%%%%%%%%%%% ANURAG GUPTA %%%%%%%%%%%%%%
clear all;
clc;
start=2;
last=5;
num=last-start+1;
imDir=fullfile('self10');
im=imageSet(imDir);
scale=0.1;
[s r n]=size(read(im,start));
% if(n~=1)
%     image=imresize(rgb2gray(read(im,start)),scale);
% else
%     image=imresize((read(im,start)),scale);
% end
image=imresize(rgb2gray(read(im,start)),scale);
s=size(image);
% i2=imresize(rgb2gray(imread('image2.jpg')),scale);
% i3=imresize(rgb2gray(imread('image3.jpg')),scale);
% i4=imresize(rgb2gray(imread('image4.jpg')),scale);
% i5=imresize(rgb2gray(imread('image5.jpg')),scale);
points=detectSURFFeatures(image);
% imshow(i1);
% hold on;
% plot(points1.selectStrongest(20));
[features, points]=extractFeatures(image,points);
% plot(points(1:10));
transforms(num)=projective2d((eye(3)));

for i=start+1:last
    pointsOld=points;
    featuresOld=features;
    
%     if(n~=1)
%         image=imresize(rgb2gray(read(im,i)),scale);
%     else
%         image=imresize((read(im,start)),scale);
%     end
    image=imresize(rgb2gray(read(im,i)),scale);
    points=detectSURFFeatures(image);
    [features, points]=extractFeatures(image,points);
    
    match=matchFeatures(features,featuresOld,'unique',true);
    matchPoints=points(match(:,1),:);
    matchPointsOld=pointsOld(match(:,2),:);
    
    transforms(i-start+1)=estimateGeometricTransform(matchPoints,matchPointsOld,...
        'projective','Confidence',99.9,'MaxNumTrials', 3000);
    transforms(i-start+1).T=transforms(i-1-start+1).T*transforms(i-start+1).T;
    
end
Tinv=invert(transforms(ceil((last-start)/2)));
for i=1:num
    transforms(i).T=Tinv.T*transforms(i).T;
end

for i=1:num
    [xlim(i,:),ylim(i,:)]=outputLimits(transforms(i),[1 s(2)],[1 s(1)]);
end
% Find the minimum and maximum output limits
xMin = min([1; xlim(:)]);
xMax = max([s(2); xlim(:)]);

yMin = min([1; ylim(:)]);
yMax = max([s(1); ylim(:)]);

% Width and height of panorama.
width  = round(xMax - xMin);
height = round(yMax - yMin);

% Initialize the panorama.
panorama = zeros([height width 3], 'like', image);

blender = vision.AlphaBlender('Operation', 'Binary mask', ...
    'MaskSource', 'Input port');

% Create a 2-D spatial reference object defining the size of the panorama.
xLimits = [xMin xMax];
yLimits = [yMin yMax];
panoramaView = imref2d([height width], xLimits, yLimits);

% Create the panorama.
for i = start:last

    image = imresize(read(im, i),scale);

    % Transform I into the panorama.
    warpedImage = imwarp(image, transforms(i-start+1), 'OutputView', panoramaView);

    % Overlay the warpedImage onto the panorama.
    panorama = step(blender, panorama, warpedImage, warpedImage(:,:,1));
end

figure
imshow(panorama)
