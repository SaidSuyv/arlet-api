drop procedure if exists p_register_admin;
drop procedure if exists p_get_user;

delimiter //

create
  procedure p_register_admin
  (
    in V_NAME text,
    in V_LASTNAME text,
    in V_USERNAME text,
    in V_EMAIL text,
    in V_PWD text
  )
begin

  declare V_DONE boolean default 0;
  declare V_EXISTS boolean default 0;
  declare V_REPEATS boolean default 0;

  select count(*) into V_EXISTS from user where username = V_USERNAME;

  if V_EXISTS > 0 then set V_REPEATS = 1;
  else
    insert into user(
      name,
      lastname,
      username,
      email,
      pwd,
      f_role
    ) values(
      V_NAME,
      V_LASTNAME,
      V_USERNAME,
      V_EMAIL,
      V_PWD,
      1
    );
    set V_DONE = 1;
  end if;

  select V_DONE as v_done , V_REPEATS as v_repeats;

end//

delimiter ;

call p_register_admin("Said Ian Ramses","Suybate Vidal","saidsuyv","sirsuyvi@gmail.com","sirsv123");