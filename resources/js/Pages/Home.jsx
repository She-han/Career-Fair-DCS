import { Head, useForm } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import HeroSection from '@/Components/Home/HeroSection';
import Introduction from '@/Components/Home/Introduction';
import PartnersSlider from '@/Components/Home/PartnersSlider';
import PhotoSlider from '@/Components/Home/PhotoSlider';
import CompanyInterestForm from '@/Components/Home/CompanyInterestForm';
import FeaturesSection from '@/Components/Home/FeaturesSection';
import StatsSection from '@/Components/Home/StatsSection';
import Marquee from '@/Components/Home/Marquee';
import FlashMessages from '@/Components/FlashMessages';

export default function Home({ flash }) {
    return (
        <AppLayout>
            <Head title="Welcome to Career Fair 2026" />

            <FlashMessages flash={flash} />

            {/* Hero Section */}
            <HeroSection />

            {/* Introduction */}
            <Introduction />
           
            {/* Photo Slider - Career Fair Memories */}
            <PhotoSlider />

            <Marquee /> 

            {/* Features Section */}
            <FeaturesSection />

           

            {/* Company Interest Form */}
            <CompanyInterestForm />   

            

         
        </AppLayout>
    );
}
