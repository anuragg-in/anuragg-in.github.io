#include <opencv2/opencv.hpp>
#include <iostream>
#include <math.h>
#include <stdlib.h>

#define PI 3.14159265

using namespace std;
using namespace cv;

#include "functions.h"

int main()
{
	// drawing pattern
	int size=540, rx=20, ry=40;;
//	Mat pattern=Mat::zeros(size,size,CV_8UC1);
//	create_pattern(pattern);
	Mat pattern=imread("test1.png",0);
	imshow("pattern",pattern);
	// defining data for hough transform algorithm
	int resolution=360, resolution_max=1000, ***grad=new int**[resolution], *gradCount=new int[resolution];
	initialize_table(grad,gradCount,resolution,resolution_max);
	
	//defining gradient operator
	const int opSize=3;
	int **gradxOp=new int*[opSize], **gradyOp=new int*[opSize];
	gradient_operator(gradxOp, gradyOp, opSize);

	// generating table for pattern recognition
	generate_pattern_table(pattern, grad, gradCount, gradxOp, gradyOp, opSize);
	int temp;
	int flag=0;
	
	// drawing an image containing pattern to be identified location of
//	Mat image=Mat::zeros(size,size,CV_8UC1);
//	draw_test_image(image);
	Mat image=imread("image3.png",0);
	imshow("image2",image);
	
    // generalized hough transform
	int ***cand=new int**[size];
	int scale_number=20;
	int *scale_value=new int[scale_number];
	for(int x=1;x<=scale_number;x++)
	{
		scale_value[x-1]=x;
	}
	generalized_hough_transform(cand, scale_number, scale_value, size, image, grad, gradCount, gradxOp, gradyOp, opSize);
	
	// finding threshold
	int thresh=0;
	int max=0;
	Mat detected_image(size,size,CV_8UC3,Scalar(0,0,0));
	for(int x=0;x<scale_number;x++)
	{
		max=0;
		maximum_array(max,cand,size,size,x);
		thresh=max-50;
	
		// drawing crossbar at identified location
		if(thresh>=110)
		{
			draw_crossbar(detected_image, image, cand, size, size, x, thresh, scale_value);
		}
	}

	imshow("Arbitrary test shape",pattern);
	imwrite("shape.png",pattern);
	imshow("Image",image);
	imwrite("image.png",image);
	imshow("Detected image",detected_image);
	imwrite("detected_image.png",detected_image);
 	waitKey(0);
	destroyAllWindows();
    return 0;   
}
