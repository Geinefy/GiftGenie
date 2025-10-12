<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display the FAQ page
     */
    public function index()
    {
        // FAQ data - in a real application, this could come from a database
        $faqs = [
            [
                'category' => 'Getting Started',
                'questions' => [
                    [
                        'question' => 'What is GiftGenie?',
                        'answer' => 'GiftGenie is an AI-powered gift recommendation platform that helps you find the perfect gifts for your loved ones. Simply tell us about the recipient and the occasion, and our intelligent system will suggest personalized gift ideas.'
                    ],
                    [
                        'question' => 'How does GiftGenie work?',
                        'answer' => 'Our AI analyzes the information you provide about the gift recipient, including their interests, age, relationship to you, and the occasion. It then searches through thousands of gift options to recommend items that match their personality and your budget.'
                    ],
                    [
                        'question' => 'Is GiftGenie free to use?',
                        'answer' => 'Yes! GiftGenie is completely free to use. You can search for gifts, save favorites, and get personalized recommendations without any cost. We earn through affiliate partnerships with retailers.'
                    ]
                ]
            ],
            [
                'category' => 'Using the Platform',
                'questions' => [
                    [
                        'question' => 'How do I search for gifts?',
                        'answer' => 'Simply describe who you\'re shopping for and what the occasion is. For example: "Birthday gift for my 25-year-old sister who loves cooking and yoga." Our AI will analyze your request and provide tailored suggestions.'
                    ],
                    [
                        'question' => 'Can I save my favorite gifts?',
                        'answer' => 'Yes! When you\'re logged in, you can save any gift to your favorites by clicking the heart icon. You can view all your saved gifts in the Favorites section of your dashboard.'
                    ],
                    [
                        'question' => 'How accurate are the gift suggestions?',
                        'answer' => 'Our AI continuously learns and improves. The more specific you are with your description, the better our recommendations will be. We consider factors like age, interests, budget, and occasion to provide highly relevant suggestions.'
                    ],
                    [
                        'question' => 'Can I filter results by price?',
                        'answer' => 'Yes! You can specify your budget range when making a search, and our system will only show gifts within your price range. You can also sort results by price after getting your initial recommendations.'
                    ]
                ]
            ],
            [
                'category' => 'Account & Privacy',
                'questions' => [
                    [
                        'question' => 'Do I need an account to use GiftGenie?',
                        'answer' => 'You can browse without an account, but you need to create one to save favorites, view your search history, and get personalized recommendations based on your past searches.'
                    ],
                    [
                        'question' => 'Is my personal information secure?',
                        'answer' => 'Absolutely! We take privacy seriously. We only collect information necessary to provide our service, and we never sell your personal data. All data is encrypted and stored securely.'
                    ],
                    [
                        'question' => 'Can I delete my account and data?',
                        'answer' => 'Yes, you can delete your account at any time from your profile settings. This will permanently remove all your personal data, favorites, and search history from our system.'
                    ]
                ]
            ],
            [
                'category' => 'Shopping & Purchases',
                'questions' => [
                    [
                        'question' => 'Does GiftGenie sell products directly?',
                        'answer' => 'No, GiftGenie is a recommendation platform. We help you discover great gifts, but purchases are made directly through our retail partners. When you click on a product, you\'ll be directed to the retailer\'s website to complete your purchase.'
                    ],
                    [
                        'question' => 'Are the prices shown accurate?',
                        'answer' => 'We strive to keep prices up-to-date, but they may change on the retailer\'s website. Always check the final price on the retailer\'s site before making a purchase.'
                    ],
                    [
                        'question' => 'What if I\'m not satisfied with a purchase?',
                        'answer' => 'Since purchases are made directly with retailers, their return and refund policies apply. We recommend checking the retailer\'s return policy before purchasing. If you have issues, contact the retailer\'s customer service directly.'
                    ],
                    [
                        'question' => 'Do you offer gift wrapping services?',
                        'answer' => 'Gift wrapping availability depends on the individual retailer. Many of our partner stores offer gift wrapping services, which you can select during checkout on their website.'
                    ]
                ]
            ],
            [
                'category' => 'Technical Support',
                'questions' => [
                    [
                        'question' => 'The website is not working properly. What should I do?',
                        'answer' => 'First, try refreshing the page or clearing your browser cache. If the issue persists, please contact us through our Contact Us form with details about the problem and your browser information.'
                    ],
                    [
                        'question' => 'Can I use GiftGenie on my mobile device?',
                        'answer' => 'Yes! GiftGenie is fully responsive and works great on all devices including smartphones and tablets. Simply visit our website through your mobile browser.'
                    ],
                    [
                        'question' => 'Why aren\'t I getting any search results?',
                        'answer' => 'Try making your search more specific or check your internet connection. If you\'re still having trouble, try using different keywords or contact our support team for assistance.'
                    ]
                ]
            ]
        ];

        return view('faq', compact('faqs'));
    }
}