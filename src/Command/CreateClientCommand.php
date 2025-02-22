<?php

namespace App\Command;

use App\Entity\ClientEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:create-client',
    description: 'Creates a new client'
)]
class CreateClientCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $client = new ClientEntity();

        $firstname = $io->ask('Prénom', null, function ($firstname) {
            if (empty($firstname)) {
                throw new \RuntimeException('Le prénom ne peut pas être vide');
            }
            return $firstname;
        });

        $lastname = $io->ask('Nom', null, function ($lastname) {
            if (empty($lastname)) {
                throw new \RuntimeException('Le nom ne peut pas être vide');
            }
            return $lastname;
        });

        $email = $io->ask('Email', null, function ($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('Format d\'email invalide');
            }
            return $email;
        });

        $phoneNumber = $io->ask('Numéro de téléphone');
        $address = $io->ask('Adresse');

        $client->setFirstname($firstname);
        $client->setLastname($lastname);
        $client->setEmail($email);
        $client->setPhoneNumber($phoneNumber);
        $client->setAddress($address);

        $errors = $this->validator->validate($client);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $io->error($error->getMessage());
            }
            return Command::FAILURE;
        }

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        $io->success('Client créé avec succès !');
        return Command::SUCCESS;
    }
}