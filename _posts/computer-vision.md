---
layout: post
author: zemin 
category: Computer Vision 
demo: false 
---

# Histogram-based methods
tensor detection of feature: color, grayscale, geometry, texture infomation, motion.

## problem statement
based on color feature only

## thresholding
thresholding is the basic operator for retaining pixels in a luminance range.

## binarization

## Level Set

## Level lines
connectivity does not hold.

## Intensity-based image segmentation
membership function.

## In practice
preprocessing to reduce variability
- restoration(denoising, deblurring)
- photometric calibration
- contrast-enhancement
- statistics
- machine learning

## Performance and limitations
applicacble mostly to simple image (cartoon model)
meaningful for real-time application

# Image noise

## Additive
optical imaging
thermal imaging
quantization noise

## Multiplicative
speckle noise
PC X-Ray

## complex
Shot noise(photon counting imaging)
Impulse noise(salt & pepper)
X-Ray
SPECT

## Noise distribution
Gaussian(optical, thermal, infrared)
Heavy-tailed -- Laplace | negative exponential (speckle noise) -- SAR, LIDAR, Sonar, PC, PC X-Ray
Poisson (Shot noise) -- PET, SPECT, medical X-Ray, industrial X-Ray, Astronomical, Hyperspectral
Rician | Rayleigh (Thermal noise)
Uniform (Quantization noise)
Impulse (Salt & pepper noise)

## Modeling Issues
- noise priors

## Generic image segmentation framework
preprocessing -- segmentation -- postprocessing

### postprocessing
- artifacts removal

Contour-based approaches
- linking
- thinning

Region-based approaches
- Hole filling
- split & merge

# Image histogram
peaks -- modes

Histograms can be quantified -- histogram binning

## Generalization
- multichannel image
- regional histogram
- arbitrary (quantified) image features eg.motion/local orientation
- curse of dimensionality

## properties
- luminance statistics
- no geometric info

## qualitative properties
- skewed / narrow histogram means low contrast

## principle
Bimodal histogram

## statistical approach
likelihood test
Gaussian Mixture Model
Expectation Maximization

## prorbability density estimation
kernel estimator
standard kernel: Gaussian
kernel : positive, symmertric, decreasing, unit mass
fixed bandwidth : Parzen estimator

## Otsu's method

## Limitation
limited to single object/ background separation problems in cartoon-like images

## point-based image transforms
## linear transform : t(L)(x) = aL(x) + b
- a > 1: histogram expansion, global contrast enhancement
- a < 1: histogram contraction, widely used in medical imaging for visualization purpose

histogram stretching
into full intensity range [0, 2^b-1]

## non-linear image transforms
Logarithmic histogram stretching
- contrast enhancement of dark structures
- saturation artifacts can occur

infomation-theoretic point-based image transform
- uniform distributions maximize entropy
- cumulated normalized histogram
- empirical cumulative distribution function estimator

Histogram equalization

## generalization
- seek for a point-based transform yieldidng images with some arbitrary-shaped histogram

