import { useState, useEffect, useCallback } from 'react';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/react/24/outline';
import image1 from '../../../images/1.jpg';
import image2 from '../../../images/2.jpg';
import image3 from '../../../images/3.jpg';
import image4 from '../../../images/4.jpg';
import image5 from '../../../images/5.jpg';
import image6 from '../../../images/6.jpg';

export default function PhotoSlider() {
    const [currentSlide, setCurrentSlide] = useState(0);
    const [isAutoPlaying, setIsAutoPlaying] = useState(true);

    // Career Fair photos data
    const slides = [
        {
            id: 1,
            image: image1,
            caption: 'Career Fair 2025 - Connecting Students with Leading Companies',
            alt: 'Students networking with company representatives'
        },
        {
            id: 2,
            image: image2,
            caption: 'Innovative Technology Showcases and Workshop Sessions',
            alt: 'Technology demonstration at career fair'
        },
        {
            id: 3,
            image: image3,
            caption: 'Professional Development and Interview Opportunities',
            alt: 'Professional interview session'
        },
        {
            id: 4,
            image: image4,
            caption: 'Building Tomorrow\'s Workforce - DCS Career Fair',
            alt: 'Career fair exhibition hall'
        },
        {
            id: 5,
            image: image5,
            caption: 'Inspiring Talks from Industry Experts and Alumni',
            alt: 'Keynote speaker at career fair'
        },
        {
            id: 6,
            image: image6,
            caption: 'Empowering Future Leaders Through Industry Partnerships',
            alt: 'Students and recruiters collaboration'
        }
    ];

    const nextSlide = useCallback(() => {
        setCurrentSlide((prev) => (prev + 1) % slides.length);
    }, [slides.length]);

    const prevSlide = () => {
        setCurrentSlide((prev) => (prev - 1 + slides.length) % slides.length);
    };

    const goToSlide = (index) => {
        setCurrentSlide(index);
        setIsAutoPlaying(false);
    };

    // Auto-play functionality
    useEffect(() => {
        if (!isAutoPlaying) return;

        const interval = setInterval(() => {
            nextSlide();
        }, 5000); // Change slide every 5 seconds

        return () => clearInterval(interval);
    }, [isAutoPlaying, nextSlide]);

    return (
        <section className="relative w-full py-20 overflow-hidden transition-colors duration-500 bg-gray-50 dark:bg-gray-800">
            <div className="container px-4 mx-auto sm:px-6 lg:px-8">
                {/* Section Header */}
                <div className="mb-16 text-center">
                    <h2 className="mb-4 text-4xl font-bold text-transparent md:text-5xl bg-gradient-to-r from-blue-700 via-purple-600 to-cyan-600 dark:from-blue-300 dark:via-purple-400 dark:to-cyan-400 bg-clip-text drop-shadow-lg">
                        Ruhuna DCS Career Fair '25 Memories
                    </h2>
                    <p className="max-w-2xl mx-auto text-lg text-gray-700 dark:text-gray-300">
                        Relive the moments that shaped careers and created lasting connections
                    </p>
                </div>

                {/* Slider Container */}
                <div className="relative mx-auto max-w-9xl group">
                    {/* Main Slider */}
                    <div className="relative h-[400px] md:h-[500px] lg:h-[600px] rounded-2xl overflow-hidden shadow-2xl">
                        {slides.map((slide, index) => (
                            <div
                                key={slide.id}
                                className={`absolute inset-0 transition-all duration-700 ease-in-out ${
                                    index === currentSlide
                                        ? 'opacity-100 scale-100'
                                        : 'opacity-0 scale-105'
                                }`}
                            >
                                {/* Image with overlay gradient */}
                                <div className="relative w-full h-full">
                                    <img
                                        src={slide.image}
                                        alt={slide.alt}
                                        className="object-cover w-full h-full"
                                    />
                                    {/* Gradient overlay for better text readability */}
                                    <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent" />
                                </div>

                                {/* Caption */}
                                <div className="absolute bottom-0 left-0 right-0 p-6 transition-all duration-700 transform md:p-10">
                                    <div className="max-w-4xl mx-auto">
                                        <p className="text-xl font-bold leading-tight text-white md:text-3xl drop-shadow-lg">
                                            {slide.caption}
                                        </p>
                                        <div className="flex items-center mt-4 space-x-2">
                                            <div className="w-16 h-1 rounded-full bg-gradient-to-r from-blue-500 to-purple-500" />
                                            <span className="text-sm text-white/80">
                                                {index + 1} of {slides.length}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* Navigation Arrows */}
                    <button
                        onClick={prevSlide}
                        onMouseEnter={() => setIsAutoPlaying(false)}
                        className="absolute p-3 transition-all duration-300 -translate-y-1/2 rounded-full shadow-lg opacity-0 left-4 top-1/2 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm group-hover:opacity-100 hover:scale-110 hover:bg-white dark:hover:bg-gray-700"
                        aria-label="Previous slide"
                    >
                        <ChevronLeftIcon className="w-6 h-6 text-gray-800 dark:text-white" />
                    </button>

                    <button
                        onClick={nextSlide}
                        onMouseEnter={() => setIsAutoPlaying(false)}
                        className="absolute p-3 transition-all duration-300 -translate-y-1/2 rounded-full shadow-lg opacity-0 right-4 top-1/2 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm group-hover:opacity-100 hover:scale-110 hover:bg-white dark:hover:bg-gray-700"
                        aria-label="Next slide"
                    >
                        <ChevronRightIcon className="w-6 h-6 text-gray-800 dark:text-white" />
                    </button>

                    {/* Dot Indicators */}
                    <div className="absolute flex items-center space-x-3 -translate-x-1/2 -bottom-8 left-1/2">
                        {slides.map((_, index) => (
                            <button
                                key={index}
                                onClick={() => goToSlide(index)}
                                className={`transition-all duration-300 rounded-full ${
                                    index === currentSlide
                                        ? 'w-10 h-3 bg-gradient-to-r from-blue-600 to-purple-600'
                                        : 'w-3 h-3 bg-gray-400 dark:bg-gray-600 hover:bg-gray-500 dark:hover:bg-gray-500'
                                }`}
                                aria-label={`Go to slide ${index + 1}`}
                            />
                        ))}
                    </div>
                </div>

               
            </div>
        </section>
    );
}
