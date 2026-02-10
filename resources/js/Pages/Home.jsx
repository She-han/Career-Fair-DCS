import { Head, useForm } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import HeroSection from '@/Components/Home/HeroSection';
import PartnersSlider from '@/Components/Home/PartnersSlider';
import CompanyInterestForm from '@/Components/Home/CompanyInterestForm';
import FeaturesSection from '@/Components/Home/FeaturesSection';
import StatsSection from '@/Components/Home/StatsSection';
import FlashMessages from '@/Components/FlashMessages';

export default function Home({ flash }) {
    return (
        <AppLayout>
            <Head title="Welcome to Career Fair 2026" />

            <FlashMessages flash={flash} />

            {/* Hero Section */}
            <HeroSection />

            {/* Partners Slider */}
            <PartnersSlider />

            {/* Company Interest Form */}
            <CompanyInterestForm />

            {/* Features Section */}
            <FeaturesSection />

            {/* Stats Section */}
            <StatsSection />
        </AppLayout>
    );
}
