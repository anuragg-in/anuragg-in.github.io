%%%%%%%%%%% ANURAG GUPTA %%%%%%%%%%%%%
clc;
clear all;
scale=0.25;
i1=imread('view1.png');
i2=imread('view0.png');
i3=imread('view2.png');
% it is necessary to convert image to double or else negative difference
% would get converted to a positive number while sum of squared difference
i1=imresize(im2double(rgb2gray(i1)),scale);
i2=imresize(im2double(rgb2gray(i2)),scale);
i3=imresize(im2double(rgb2gray(i3)),scale);
s1=size(i1);
% block size for matching
halfWinSize=3;
winSize=2*halfWinSize+1;
% variables to store sum of squared difference
error=0;
errorMin=10000000;
% maximum disparity value
dispMax=40;
% variable to store disparity
disparity=zeros(s1);
disparity2=zeros(s1);
% initializing progress bar
h=waitbar(0,'0 %');
for x=1+halfWinSize:s1(1)-halfWinSize
    for y=1+halfWinSize:s1(2)-halfWinSize
        % storing block for comparison
        im1=i1(x-halfWinSize:x+halfWinSize,y-halfWinSize:y+halfWinSize);
        errorMin=10000000;
        d=0;
        % comparing stored block with second image block
        for i=y:min(s1(2)-halfWinSize,y+dispMax)
            error=0;
            im2=i2(x-halfWinSize:x+halfWinSize,i-halfWinSize:i+halfWinSize);
            error=sum(sum(abs(im2-im1)));
            % calculating minimum of sum of squared difference
            if(error<errorMin)
                errorMin=error;
                d=abs(i-y);
            end
        end
        disparity(x,y)=d;
        errorMin=10000000;
        d=0;
        for i=max(1+halfWinSize,y-dispMax):y
            error=0;
            im3=i3(x-halfWinSize:x+halfWinSize,i-halfWinSize:i+halfWinSize);
            error=sum(sum(abs(im3-im1)));
            % calculating minimum of sum of squared difference
            if(error<errorMin)
                errorMin=error;
                d=i-y;
            end
        end
        disparity2(x,y)=abs(d);
    end
    waitbar((x-halfWinSize)/(s1(1)-halfWinSize*2),h,sprintf('%d %%',floor((x-halfWinSize)/(s1(1)-halfWinSize*2)*100)));
end
close(h);
% displaying disparity matrix
figure(3);
for i=1:s1(1)
    for j=1:s1(2)
        if(disparity(i,j)>18)
            disparity(i,j)=0;
        end
    end
end
imshow(mat2gray(disparity));
colormap('jet');
colorbar;
figure(4);
for i=1:s1(1)
    for j=1:s1(2)
        if(disparity2(i,j)>18)
            disparity2(i,j)=0;
            i1(i,j)=0;
        end
    end
end
imshow(mat2gray(disparity2));
colormap('jet');
colorbar;
figure(5);
imshow(mat2gray((disparity+disparity2)/2));
colormap('jet');
colorbar;
% imshow(i1);
